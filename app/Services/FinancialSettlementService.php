<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class FinancialSettlementService
{
   
    public function createOrderItemsWithPricingBreakdown(Order $order, array $cart_items): array
    {
        $totalAmount = 0;
        $totalPlatformCommission = 0;
        $totalLogisticsAmount = 0;
        $createdItems = [];

        DB::transaction(function () use ($order, $cart_items, &$totalAmount, &$totalPlatformCommission, &$totalLogisticsAmount, &$createdItems) {
            foreach ($cart_items as $productId => $details) {
                $product = Product::findOrFail($productId);
                $quantity = $details['quantity'] ?? 1;

                
                if ($product->stock_quantity < $quantity) {
                    throw new \Exception("Insufficient stock for product: {$product->title}. Available: {$product->stock_quantity}, Requested: {$quantity}");
                }

               
                $totalPricePerUnit = $product->price;
                $basePrice = $product->base_price ?? $totalPricePerUnit;
                $shippingFee = 0.0;

               
                if (abs(($basePrice + $shippingFee) - $totalPricePerUnit) > 0.01 && $shippingFee === 0.0) {
                    $basePrice = $totalPricePerUnit;
                }

               
                $commissionRate = 10; 
                $platformCommission = ($basePrice * $commissionRate) / 100;
                $artisanEarnings = $basePrice - $platformCommission;

                
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'artisan_id' => $product->user_id,
                    'product_id' => $product->id,
                    'product_title' => $product->title,
                    'product_description' => $details['description'] ?? null,
                    'price' => $totalPricePerUnit,
                    'quantity' => $quantity,
                    'subtotal' => $totalPricePerUnit * $quantity,
                    'base_product_price' => $basePrice,
                    'shipping_fee_per_item' => $shippingFee,
                    'platform_commission' => $platformCommission,
                    'artisan_earnings' => $artisanEarnings,
                    'payment_status' => 'pending',
                    'fulfillment_status' => 'pending',
                ]);

               
                $product->decrement('stock_quantity', $quantity);

               
                $totalAmount += $orderItem->subtotal;
                $totalPlatformCommission += $platformCommission * $quantity;
                $totalLogisticsAmount += $shippingFee * $quantity;

                $createdItems[] = $orderItem;
            }
        });

       
        $order->update([
            'total_amount' => $totalAmount,
            'escrow_status' => 'awaiting_payment',
            'platform_reserved_commission' => $totalPlatformCommission,
            'logistics_pool_amount' => 0,
            'payment_received_at' => null,
        ]);

        return [
            'items' => $createdItems,
            'order' => $order,
            'totals' => [
                'subtotal' => $totalAmount,
                'shipping' => 0,
                'total' => $totalAmount,
                'platform_commission' => $totalPlatformCommission,
            ]
        ];
    }

   
    public function getPricingBreakdown(Order $order): array
    {
        $items = $order->items()->get();

        $baseProductTotal = 0;
        $shippingTotal = 0;
        $platformCommissionTotal = 0;
        $artisanEarningsTotal = 0;

        foreach ($items as $item) {
            $baseProductTotal += $item->base_product_price * $item->quantity;
            $shippingTotal += 0;
            $platformCommissionTotal += $item->platform_commission * $item->quantity;
            $artisanEarningsTotal += $item->artisan_earnings * $item->quantity;
        }

        return [
            'base_product_total' => $baseProductTotal,
            'shipping_total' => 0,
            'total_charged' => $baseProductTotal,
            'platform_commission' => $platformCommissionTotal,
            'artisan_earnings' => $artisanEarningsTotal,
            'breakdown_items' => $items->map(function ($item) {
                return [
                    'product_title' => $item->product_title,
                    'quantity' => $item->quantity,
                    'base_price_per_unit' => $item->base_product_price,
                    'shipping_per_unit' => 0,
                    'total_per_item' => $item->price,
                    'subtotal' => $item->subtotal,
                ];
            })->toArray(),
        ];
    }

    
    public function settlePaymentToArtisan(Order $order): array
    {
        $order->refresh();

        if ($order->payment_status !== 'paid') {
            throw new \Exception('Order payment has not been verified.');
        }

        if ($order->escrow_status === 'released_to_artisan') {
            return $this->getSettlementSummary($order);
        }

        DB::transaction(function () use ($order) {
            $items = $order->items()
                ->where('payment_status', 'escrowed')
                ->lockForUpdate()
                ->get();

            foreach ($items as $item) {
                $artisan = User::findOrFail($item->artisan_id);
                $earnings = round((float) $item->artisan_earnings * (int) $item->quantity, 2);

                $artisan->increment('wallet_balance', $earnings);

                $commissionRate = 10;

                \App\Models\Commission::updateOrCreate(
                    [
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'artisan_id' => $item->artisan_id,
                    ],
                    [
                        'order_item_id' => $item->id,
                        'order_amount' => (float) $item->base_product_price * (int) $item->quantity,
                        'commission_rate' => $commissionRate,
                        'commission_amount' => $earnings,
                        'status' => 'completed',
                        'completed_at' => now(),
                    ]
                );

                $item->update([
                    'payment_status' => 'settled',
                    'payment_settled_at' => now(),
                ]);
            }

            $order->update([
                'escrow_status' => 'released_to_artisan',
            ]);
        });

        return $this->getSettlementSummary($order->fresh());
    }

   
    public function getSettlementSummary(Order $order): array
    {
        $items = $order->items()->get();
        $breakdown = $this->getPricingBreakdown($order);

        $itemSettlements = [];
        foreach ($items as $item) {
            $artisan = User::findOrFail($item->artisan_id);
            $itemSettlements[] = [
                'artisan_name' => $artisan->name,
                'artisan_id' => $artisan->id,
                'product_title' => $item->product_title,
                'quantity' => $item->quantity,
                'base_price' => $item->base_product_price * $item->quantity,
                'platform_commission' => $item->platform_commission * $item->quantity,
                'artisan_net_earnings' => $item->artisan_earnings * $item->quantity,
                'shipping_fee_allocated' => $item->shipping_fee_per_item * $item->quantity,
                'payment_status' => $item->payment_status,
            ];
        }

        return [
            'order_id' => $order->id,
            'total_order_value' => $order->total_amount,
            'platform_commission_total' => $breakdown['platform_commission'],
            'logistics_pool_allocation' => $breakdown['shipping_total'],
            'settlement_summary' => [
                'funds_held_in_escrow' => $order->total_amount,
                'platform_retains' => $breakdown['platform_commission'],
                'distributed_to_artisans' => $breakdown['artisan_earnings'],
                'allocated_to_logistics' => $breakdown['shipping_total'],
            ],
            'per_artisan_settlements' => $itemSettlements,
        ];
    }

    
    public function cancelOrderAndRestoreStock(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $items = $order->items()->get();

            foreach ($items as $item) {
                if ($item->payment_status !== 'settled') {
                    Product::findOrFail($item->product_id)->increment('stock_quantity', $item->quantity);
                }

                $item->update([
                    'payment_status' => 'pending',
                    'fulfillment_status' => 'cancelled',
                ]);
            }

            $order->update([
                'status' => 'cancelled',
                'escrow_status' => 'awaiting_payment',
            ]);
        });
    }
}
