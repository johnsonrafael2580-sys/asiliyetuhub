<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\AutomaticPaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.pesapal.base_url', 'https://pay.pesapal.com/v3/api');
    }

    public function show(Order $order)
    {
        $user = auth()->user();

        if (! $user || ((int) $order->customer_id !== (int) $user->id && $user->role !== 'admin')) {
            abort(403);
        }

        $order->load(['items.product', 'items.artisan']);

        return view('orders.payment', compact('order'));
    }

   
    public function status(Order $order)
    {
        $user = auth()->user();

        if (! $user || ((int) $order->customer_id !== (int) $user->id && $user->role !== 'admin')) {
            abort(403);
        }

        return response()->json([
            'payment_status' => $order->fresh()->payment_status,
        ]);
    }

   
    public function submit(Order $order, AutomaticPaymentService $automaticPaymentService)
    {
        $user = auth()->user();

        if (! $user || ((int) $order->customer_id !== (int) $user->id && $user->role !== 'admin')) {
            abort(403);
        }

        try {
            $automaticPaymentService->initiate($order);

            return redirect()->route('orders.payment', $order)
                ->with('success', 'Message imetumwa tena kwenye simu yako.');
        } catch (\Throwable $e) {
            Log::error('Order payment submit failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('orders.payment', $order)
                ->with('error', 'Message ya malipo haikuweza kutumwa. Tafadhali jaribu tena.');
        }
    }

    private function getAuthToken(): ?string
    {
        try {
            $response = Http::withoutVerifying()
                ->post("{$this->baseUrl}/Auth/RequestToken", [
                    'consumer_key' => config('services.pesapal.consumer_key'),
                    'consumer_secret' => config('services.pesapal.consumer_secret'),
                ]);

            if ($response->successful()) {
                return $response->json('token');
            }

            Log::error('Pesapal Auth Failed:', ['body' => $response->body()]);
            return null;
        } catch (\Exception $e) {
            Log::error('Pesapal Auth Exception: ' . $e->getMessage());
            return null;
        }
    }

   
    private function registerIpnId(string $token): ?string
    {
        try {
            $callbackUrl = config('services.pesapal.callback_url') 
                ?? route('payment.callback', [], false);

            $response = Http::withoutVerifying()
                ->withToken($token)
                ->post("{$this->baseUrl}/URLSetup/RegisterIPN", [
                    'url' => $callbackUrl,
                    'ipn_notification_type' => 'GET',
                ]);

            if ($response->successful()) {
                return $response->json('ipn_id');
            }

            Log::error('Pesapal IPN Registration Failed:', ['body' => $response->body()]);
            return null;
        } catch (\Exception $e) {
            Log::error('Pesapal IPN Setup Exception: ' . $e->getMessage());
            return null;
        }
    }

    
    public function initiatePayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
        ]);

        $order = DB::table('orders')->where('id', $request->order_id)->first();
        if (! $order) {
            return back()->with('error', 'The targeted order record does not exist.');
        }

        $token = $this->getAuthToken();
        if (! $token) {
            return back()->with('error', 'Unable to authenticate with secure payment server.');
        }

        $notificationId = $this->registerIpnId($token);
        if (! $notificationId) {
            return back()->with('error', 'Unable to configure payment callback endpoint.');
        }

        $phone = preg_replace('/[^0-9]/', '', $order->customer_phone ?? '0712345678');
        $nameParts = explode(' ', trim($order->customer_name ?? 'Guest Customer'));

        $payload = [
            'id' => 'AYH-REF-' . $order->id . '-' . time(),
            'currency' => $order->ORDER_CURRENCY ?? 'TZS',
            'amount' => (float) $order->total_amount,
            'description' => 'AsiliYetuHub Order #' . $order->id . ' Payment Processing',
            'callback_url' => config('services.pesapal.callback_url') ?? route('payment.callback', [], false),
            'notification_id' => $notificationId,
            'billing_address' => [
                'email_address' => $order->customer_email ?? 'billing@asiliyetuhub.co.tz',
                'phone_number' => $phone,
                'country_code' => 'TZ',
                'first_name' => $nameParts[0] ?? 'Guest',
                'middle_name' => '',
                'last_name' => $nameParts[1] ?? 'Customer',
                'line_1' => 'Tanzania',
                'city' => 'Dar es Salaam',
            ],
        ];

        $response = Http::withoutVerifying()
            ->withToken($token)
            ->post("{$this->baseUrl}/Transactions/SubmitOrderRequest", $payload);

        $orderData = $response->json();

        if ($response->successful() && isset($orderData['redirect_url'])) {
            DB::table('order_payments')->insert([
                'order_id' => $order->id,
                'customer_id' => $order->customer_id ?? 16,
                'agent_key' => 'pesapal',
                'agent_name' => 'Pesapal Gateway',
                'payment_method' => 'card_or_mobile',
                'amount' => $order->total_amount,
                'sender_phone' => $order->customer_phone ?? null,
                'transaction_id' => 'TZ-PESA-' . time(),
                'checkout_request_id' => $orderData['merchant_reference'] ?? null,
                'provider_transaction_id' => $orderData['order_tracking_id'] ?? null,
                'provider_status' => 'initiated',
                'provider_response' => json_encode($orderData),
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            return redirect()->away($orderData['redirect_url']);
        }

        Log::error('Pesapal Submit Order Error:', ['payload' => $orderData]);
        return back()->with('error', 'Could not open secure gateway panel.');
    }

    
    public function handleCallback(Request $request)
    {
        $merchantReference = $request->query('OrderMerchantReference');
        $trackingId = $request->query('OrderTrackingId');

        if ($trackingId) {
            $statusData = $this->checkTransactionStatus($trackingId);

            if ($statusData && isset($statusData['status_code']) && (int) $statusData['status_code'] === 1) {
                $this->finalizePaymentRecords($merchantReference, $trackingId, $statusData);
                return redirect()->route('home')->with('success', 'Malipo yamepokelewa vizuri! Asante kwa kusaidia kazi za mikono za Tanzania.');
            }
        }

        return redirect()->route('home')->with('error', 'Malipo hayajakamilika bado au yamefeli. Tafadhali jaribu tena.');
    }

    
    public function handleIpnNotification(Request $request)
    {
        $merchantReference = $request->query('OrderMerchantReference');
        $trackingId = $request->query('OrderTrackingId');
        $notificationType = $request->query('OrderNotificationType');

        if ($trackingId) {
            $statusData = $this->checkTransactionStatus($trackingId);

            if ($statusData && isset($statusData['status_code']) && (int) $statusData['status_code'] === 1) {
                $this->finalizePaymentRecords($merchantReference, $trackingId, $statusData);
            }
        }

        return response()->json([
            'orderNotificationType' => $notificationType,
            'orderTrackingId' => $trackingId,
            'orderMerchantReference' => $merchantReference,
            'status' => 200,
        ], 200);
    }

    
    private function finalizePaymentRecords($merchantReference, $trackingId, $statusData)
    {
        preg_match('/AYH-REF-(\d+)/', $merchantReference, $matches);
        $orderId = $matches[1] ?? null;

        if (! $orderId) {
            return;
        }

        DB::transaction(function () use ($orderId, $trackingId, $statusData) {
            DB::table('orders')->where('id', $orderId)->update([
                'status' => 'processing',
                'payment_status' => 'paid',
                'escrow_status' => 'escrowed',
                'payment_received_at' => Carbon::now(),
                'payment_verified_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::table('order_items')->where('order_id', $orderId)->update([
                'payment_status' => 'escrowed',
                'updated_at' => Carbon::now(),
            ]);

            DB::table('order_payments')
                ->where('order_id', $orderId)
                ->where('provider_transaction_id', $trackingId)
                ->update([
                    'status' => 'verified',
                    'provider_status' => 'COMPLETED',
                    'provider_response' => json_encode($statusData),
                    'verified_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        });
    }

    
    private function checkTransactionStatus(string $trackingId)
    {
        $token = $this->getAuthToken();
        if (! $token) {
            return null;
        }

        $response = Http::withoutVerifying()
            ->withToken($token)
            ->get("{$this->baseUrl}/Transactions/GetTransactionStatus", [
                'orderTrackingId' => $trackingId,
            ]);

        return $response->successful() ? $response->json() : null;
    }

    public function handleCancel()
    {
        return redirect()->route('home')->with('info', 'Umeahirisha mchakato wa malipo.');
    }
}
