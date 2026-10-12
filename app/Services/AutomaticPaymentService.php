<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\ProductRequest;
use App\Notifications\OrderStatusNotification;
use App\Notifications\PaymentStatusNotification;
use App\Notifications\ProductOrderedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AutomaticPaymentService
{
    public function __construct(
        private CustomerCommunicationService $communication,
    ) {}

   public function initiate(Order $order): OrderPayment
    {
        
        return OrderPayment::create([
            'order_id' => $order->id,
            'customer_id' => $order->customer_id,
            'agent_key' => 'pesapal',
            'agent_name' => 'PesaPal Gateway',
            'payment_method' => 'card_or_mobile',
            'amount' => $order->total_amount,
            'sender_phone' => $order->customer_phone ?? 'N/A',
            'transaction_id' => 'PENDING-' . strtoupper(bin2hex(random_bytes(8))),
            'status' => 'pending',
            'submitted_at' => now(),
        ]);
    }

    public function markPaid(OrderPayment $payment, array $callback = []): Order
    {
        return DB::transaction(function () use ($payment, $callback) {
            $payment = OrderPayment::query()->lockForUpdate()->with('order.customer')->findOrFail($payment->id);
            $order = Order::query()->lockForUpdate()->findOrFail($payment->order_id);

            if ($order->payment_status === 'paid') {
                return $order;
            }

            $payment->update([
                'status' => 'verified',
                'provider_status' => $callback['status'] ?? 'success',
                'provider_transaction_id' => $callback['transaction_id'] ?? $payment->provider_transaction_id,
                'provider_response' => $callback['raw'] ?? $payment->provider_response,
                'verified_at' => now(),
                'submitted_at' => $payment->submitted_at ?? now(),
            ]);

            $order->update([
                'payment_status' => 'paid',
                'escrow_status' => 'escrowed',
                'payment_received_at' => now(),
                'payment_verified_at' => now(),
                'payment_verified_by' => null,
                'status' => 'processing',
            ]);

            $order->items()->update(['payment_status' => 'escrowed']);

            foreach ($order->items()->with('product')->get() as $item) {
                $request = ProductRequest::firstOrCreate(
                    ['order_item_id' => $item->id],
                    [
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'user_id' => $order->customer_id,
                        'customer_name' => $order->customer_name,
                        'customer_phone' => $order->customer_phone,
                        'message' => $item->product_description ?: ($order->customer_note ?: 'Paid order #' . $order->id),
                        'status' => 'processing',
                        'delivery_location' => $order->delivery_location,
                        'delivery_note' => $order->customer_note,
                        'tourist_phone' => $order->customer_phone,
                        'tourist_email' => $order->customer_email,
                    ]
                );

                $artisan = $item->artisan;
                if ($artisan) {
                    $artisan->notify(new ProductOrderedNotification($order, $item));
                    $this->communication->send(
                        $artisan->email,
                        $artisan->phone,
                        "New paid order #{$order->id}",
                        "Asili Yetu Hub: order #{$order->id} for {$item->product_title} has been paid automatically. Prepare the item for shipment. Customer description: " . ($request->message ?: 'None')
                    );
                }
            }

            $customer = $order->customer;
            if ($customer) {
                $customer->notify(new PaymentStatusNotification(
                    $order,
                    'paid',
                    "Malipo ya oda #{$order->id} yamepokelewa moja kwa moja. Oda sasa inachakatwa."
                ));
                $this->communication->send(
                    $customer->email,
                    $customer->phone,
                    "Payment received for order #{$order->id}",
                    "Asili Yetu Hub: payment for order #{$order->id} of TZS " . number_format((float) $order->total_amount, 2) . " was received automatically. You can follow shipment status from your dashboard."
                );
            }

            return $order->fresh();
        });
    }

    public function findPaymentForCallback(array $payload): ?OrderPayment
    {
        $requestId = $payload['checkoutRequestId'] ?? $payload['checkout_request_id'] ?? $payload['requestId'] ?? null;
        $transactionId = $payload['transactionId'] ?? $payload['transaction_id'] ?? null;

        if ($requestId) {
            $payment = OrderPayment::where('checkout_request_id', $requestId)->first();
            if ($payment) return $payment;
        }

        if ($transactionId) {
            $payment = OrderPayment::where('provider_transaction_id', $transactionId)->first();
            if ($payment) return $payment;
            $payment = OrderPayment::where('transaction_id', $transactionId)->first();
            if ($payment) return $payment;
        }

        $metadata = $payload['metadata'] ?? null;
        if (is_string($metadata)) {
            $metadata = json_decode($metadata, true);
        }
        $orderId = is_array($metadata) ? ($metadata['order_id'] ?? null) : ($payload['order_id'] ?? null);

        return $orderId ? OrderPayment::where('order_id', $orderId)->latest()->first() : null;
    }

    public function isSuccessful(array $payload): bool
    {
        $status = strtolower((string) ($payload['status'] ?? $payload['transactionStatus'] ?? $payload['responseCode'] ?? ''));
        if (in_array($status, ['success', 'successful', 'completed', 'paid', '0'], true)) {
            return true;
        }

        $provider = $payload['provider'] ?? null;
        if (is_string($provider) && strtolower($provider) === 'local_sandbox') {
            return true;
        }

        $requestId = $payload['checkoutRequestId'] ?? $payload['checkout_request_id'] ?? $payload['requestId'] ?? null;
        if (is_string($requestId) && str_starts_with(strtoupper($requestId), 'LOCAL-')) {
            return true;
        }

        return false;
    }

    public function normalizePhone(?string $phone): string
    {
        if (! $phone) {
            return 'N/A';
        }

        $cleaned = preg_replace('/[^\d+]/', '', $phone);

        if (str_starts_with($cleaned, '0')) {
            return '+255' . substr($cleaned, 1);
        }

        if (! str_starts_with($cleaned, '+')) {
            return '+' . $cleaned;
        }

        return $cleaned;
    }
}
