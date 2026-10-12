<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Order;
use App\Models\ProductRequest;
use App\Services\ArtisanEarningsReconciliationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommissionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'artisan') {
            return redirect()->back()->with('error', 'Only artisans can view commission details');
        }

       
        app(ArtisanEarningsReconciliationService::class)->reconcile($user->id);

        $commissions = Commission::where('artisan_id', $user->id)
            ->with(['product', 'order', 'newOrder'])
            ->latest()
            ->paginate(15);

        $stats = [
            
            'total_earned' => Commission::where('artisan_id', $user->id)
                ->where('status', 'completed')
                ->sum('commission_amount'),

           
            'pending_commissions' => Commission::where('artisan_id', $user->id)
                ->where('status', 'pending')
                ->selectRaw('SUM(order_amount - commission_amount) as platform_fee')
                ->value('platform_fee') ?? 0,

           
            'completed_orders' => Commission::where('artisan_id', $user->id)
                ->where('status', 'completed')
                ->count(),
        ];

        return view('commissions.index', compact('commissions', 'stats'));
    }

   
    public function createFromOrder($order): Commission
    {
        if ($order instanceof Order) {
            $items = $order->items()->get();
            $lastCommission = null;

            foreach ($items as $item) {
                $amount = (float) $item->base_product_price * (int) $item->quantity;
                $rate = 10;
                $net = (float) $item->artisan_earnings * (int) $item->quantity;

                $lastCommission = Commission::updateOrCreate(
                    [
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'artisan_id' => $item->artisan_id,
                    ],
                    [
                        'order_amount' => $amount,
                        'commission_rate' => $rate,
                        'commission_amount' => $net,
                        'status' => 'pending',
                        'completed_at' => null,
                    ]
                );
            }

            return $lastCommission ?? throw new \RuntimeException('Order has no items to settle.');
        }

        if (!$order instanceof ProductRequest) {
            throw new \InvalidArgumentException('Unsupported order type.');
        }

        $product = $order->product;
        if (!$product) {
            throw new \RuntimeException('The requested product no longer exists.');
        }

        $amount = (float) ($product->price ?? 0);
        $rate = 10;
        $platformFee = round($amount * ($rate / 100), 2);
        $artisanEarnings = round($amount - $platformFee, 2);

        return Commission::updateOrCreate(
            [
                'order_id' => $order->id,
                'product_id' => $product->id,
                'artisan_id' => $product->user_id,
            ],
            [
                'order_amount' => $amount,
                'commission_rate' => $rate,
                'commission_amount' => $artisanEarnings,
                'status' => 'pending',
                'completed_at' => null,
            ]
        );
    }

    public function markCompleted(Commission $commission)
    {
        if (Auth::user()->id !== $commission->artisan_id && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $commission->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return response()->json(['message' => 'Commission marked as completed', 'commission' => $commission]);
    }

    public function show(Commission $commission)
    {
        if (Auth::user()->id !== $commission->artisan_id && Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        return view('commissions.show', compact('commission'));
    }
}
