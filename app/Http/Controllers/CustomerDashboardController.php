<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!in_array($user->role, ['customer', 'tourist'], true)) {
            return redirect()->route('dashboard');
        }

        $orders = $user->orders()
            ->with(['items.product', 'items.artisan', 'latestPayment'])
            ->whereNull('customer_hidden_at')
            ->latest()
            ->get();

        $newOrders = $orders->filter(function ($order) {
            return $order->created_at && $order->created_at->greaterThanOrEqualTo(now()->subDays(14));
        });

        $oldOrders = $orders->filter(function ($order) {
            return !$order->created_at || $order->created_at->lt(now()->subDays(14));
        });

        $notifications = $user->notifications()->latest()->limit(20)->get();

        return view('customer.dashboard', compact(
            'orders',
            'newOrders',
            'oldOrders',
            'notifications'
        ));
    }
}
