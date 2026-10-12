<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Notifications\ProductRequestedNotification;
use App\Services\ArtisanEarningsReconciliationService;
use App\Services\AutomaticPaymentService;
use App\Services\CustomerCommunicationService;
use App\Services\FinancialSettlementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ProductRequestController extends Controller
{
    public function store(
        Request $request,
        Product $product,
        FinancialSettlementService $financialService,
        AutomaticPaymentService $automaticPaymentService,
        CustomerCommunicationService $communication
    ) {
        if (! auth()->check()) {
            return redirect()->guest(route('login'));
        }

        $customer = auth()->user();
        if (! in_array($customer->role, ['customer', 'tourist'], true)) {
            return back()->with('error', 'Akaunti ya customer inahitajika kutuma ombi la bidhaa.');
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:100'],
            'message' => ['required', 'string', 'max:2000'],
            'delivery_location' => ['required', 'string', 'max:255'],
        ]);

        if ((int) $product->stock_quantity < (int) $validated['quantity']) {
            return back()->with('error', 'Stock iliyopo haitoshi kwa quantity uliyochagua.');
        }

       
        $calculatedTotal = $product->price * (int) $validated['quantity'];
        if ($calculatedTotal > 20000) {
            return back()->withInput()->with('error', 'Jumla ya kiasi cha muamala (TZS ' . number_format($calculatedTotal, 2) . ') inazidi ukomo wa Pesapal (Max TZS 20,000). Tafadhali punguza idadi ya bidhaa.');
        }

        try {
            DB::transaction(function () use ($customer, $product, $validated, $financialService, &$order, &$productRequest) {
                $orderData = [
                    'customer_id' => $customer->id,
                    'customer_name' => $customer->name,
                    'customer_phone' => $customer->phone ?? 'N/A',
                    'customer_email' => $customer->email,
                    'total_amount' => 0,
                    'status' => 'pending',
                    'payment_method' => 'mobile_money',
                    'payment_status' => 'pending',
                    'escrow_status' => 'awaiting_payment',
                ];

                if (Schema::hasColumn('orders', 'customer_note')) {
                    $orderData['customer_note'] = $validated['message'];
                }

                if (Schema::hasColumn('orders', 'delivery_location')) {
                    $orderData['delivery_location'] = $validated['delivery_location'];
                }

                if (Schema::hasColumn('orders', 'payment_status')) {
                    $orderData['payment_status'] = 'pending';
                }

                if (Schema::hasColumn('orders', 'payment_method')) {
                    $orderData['payment_method'] = 'mobile_money';
                }

                if (Schema::hasColumn('orders', 'escrow_status')) {
                    $orderData['escrow_status'] = 'awaiting_payment';
                }

                $order = Order::create($orderData);

                $financialService->createOrderItemsWithPricingBreakdown($order, [
                    $product->id => [
                        'quantity' => (int) $validated['quantity'],
                        'description' => $validated['message'],
                    ],
                ]);

                $item = $order->items()->latest('id')->firstOrFail();

               
                $productRequestData = [
                    'order_id' => $order->id,
                    'order_item_id' => $item->id,
                    'product_id' => $product->id,
                    'user_id' => $customer->id,
                    'customer_name' => $customer->name,
                    'customer_phone' => $customer->phone ?? null,
                    'message' => $validated['message'],
                    'status' => 'pending',
                    'delivery_location' => $validated['delivery_location'],
                    'delivery_note' => $validated['message'],
                    'tourist_phone' => $customer->phone ?? null,
                    'tourist_email' => $customer->email,
                ];

               
                if (Schema::hasColumn('product_requests', 'quantity')) {
                    $productRequestData['quantity'] = (int) $validated['quantity'];
                }

                if (Schema::hasColumn('product_requests', 'subtotal')) {
                    $productRequestData['subtotal'] = $item->subtotal ?? ($product->price * (int) $validated['quantity']);
                }

                $productRequest = ProductRequest::create($productRequestData);
            });

            $communication->send(
                $customer->email,
                $customer->phone,
                "Request #{$productRequest->id} received",
                "Asili Yetu Hub: your request for {$product->title} has been received. Payment prompt will be sent automatically to your phone."
            );

            $artisan = $product->artisan ?? $product->user;
            if ($artisan) {
                try {
                    $artisan->notify(new ProductRequestedNotification($productRequest));
                    $communication->send(
                        $artisan->email,
                        $artisan->phone,
                        "New product request #{$productRequest->id}",
                        "Asili Yetu Hub: {$customer->name} requested {$product->title}. Description: {$validated['message']}. Payment prompt is being processed automatically; wait for payment confirmation before fulfillment."
                    );
                } catch (\Throwable $notificationError) {
                    Log::warning('Immediate product request notification failed', ['error' => $notificationError->getMessage()]);
                }
            }

            $automaticPaymentService->initiate($order);

            return redirect()->route('orders.payment', $order)
                ->with('success', 'Request imepokelewa. Payment prompt imetumwa kwenye simu yako;');
        } catch (\Throwable $e) {
            Log::error('Automatic product request checkout failed', [
                'product_id' => $product->id,
                'customer_id' => $customer->id,
                'error' => $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Request/payment haikuweza kuanzishwa. Tafadhali jaribu tena.');
        }
    }

    public function markCompleted(Request $request, ProductRequest $productRequest)
    {
        $product = $productRequest->product;
        $artisan = $product->artisan ?? $product->user;

        if (auth()->id() !== ($artisan?->id) && auth()->user()->role !== 'admin') {
            return $request->wantsJson()
                ? response()->json(['error' => 'Unauthorized'], 403)
                : redirect()->back()->with('error', 'Unauthorized');
        }

        $productRequest->update(['status' => 'delivered']);

        try {
            app(ArtisanEarningsReconciliationService::class)->reconcile($artisan->id);
        } catch (\Throwable $e) {
            Log::error('Failed to reconcile artisan earnings: ' . $e->getMessage());
        }

        return $request->wantsJson()
            ? response()->json(['message' => 'Order marked as delivered successfully', 'productRequest' => $productRequest])
            : redirect()->back()->with('success', 'Oda imekamilika na status imesasishwa.');
    }
}
