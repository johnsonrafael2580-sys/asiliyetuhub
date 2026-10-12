<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;

class ArtisanEarningsReconciliationService
{
   
    public function reconcile(User|int|string $artisan): array
    {
        if (!$artisan instanceof User) {
            $artisan = User::query()->findOrFail((int) $artisan);
        }

        return $this->reconcileForArtisan($artisan);
    }

   
    public function reconcileForArtisan(User $artisan): array
    {
        $orders = Order::query()
            ->whereHas('items.product', function ($query) use ($artisan) {
                $query->where('artisan_id', $artisan->id);
            })
            ->whereIn('status', [
                'confirmed',
                'processing',
                'packaged',
                'dispatched',
                'in_transit',
                'out_for_delivery',
                'delivered',
            ])
            ->with([
                'items.product',
            ])
            ->get();

        $grossSales = 0.0;
        $commission = 0.0;
        $netEarnings = 0.0;

        foreach ($orders as $order) {
            foreach ($order->items as $item) {

                if (!$item->product) {
                    continue;
                }

                if ((int) $item->product->artisan_id !== (int) $artisan->id) {
                    continue;
                }

                $quantity = (int) ($item->quantity ?? 1);

                $unitPrice = (float) (
                    $item->unit_price
                    ?? $item->price
                    ?? $item->product->price
                    ?? 0
                );

                $lineTotal = (float) (
                    $item->total
                    ?? $item->subtotal
                    ?? 0
                );

                
                if ($lineTotal <= 0 && $unitPrice > 0) {
                    $lineTotal = $unitPrice * $quantity;
                }

                if ($lineTotal <= 0) {
                    continue;
                }

                $grossSales += $lineTotal;

                
                $orderCommission = 0.0;

                $reservedCommission = (float) (
                    $order->platform_reserved_commission ?? 0
                );

                $orderTotal = (float) (
                    $order->total ?? 0
                );

                if (
                    $reservedCommission > 0 &&
                    $orderTotal > 0
                ) {
                    $orderCommission =
                        $reservedCommission
                        * ($lineTotal / $orderTotal);
                }

                $commission += $orderCommission;

                $netEarnings += (
                    $lineTotal - $orderCommission
                );
            }
        }

        return [
            'orders_count' => $orders->count(),

            'gross_sales' => round(
                $grossSales,
                2
            ),

            'commission' => round(
                $commission,
                2
            ),

            'net_earnings' => round(
                $netEarnings,
                2
            ),
        ];
    }

   
    public function reconcileAll(): array
    {
        $artisans = User::query()
            ->where('role', 'artisan')
            ->get();

        $results = [];

        foreach ($artisans as $artisan) {
            $results[$artisan->id] =
                $this->reconcileForArtisan($artisan);
        }

        return $results;
    }

    
    public function summaryForArtisan(
        User|int|string $artisan
    ): array {
        return $this->reconcile($artisan);
    }
}
