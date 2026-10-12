<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\FinancialSettlementService;
use App\Notifications\OrderStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = Order::with(['items.product', 'items.artisan'])
            ->where('customer_id', $user->id)
            ->whereNull('customer_hidden_at')
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order, FinancialSettlementService $financialService)
    {
        $user = Auth::user();

        if ((int) $order->customer_id !== (int) $user->id && $user->role !== 'admin') {
            abort(403);
        }

        $order->load([
            'items.product',
            'items.artisan',
            'payments' => fn ($query) => $query->latest(),
        ]);

        $pricingBreakdown = $financialService->getPricingBreakdown($order);

        return view('orders.show', compact('order', 'pricingBreakdown'));
    }

    public function hide(Request $request, Order $order)
    {
        $user = Auth::user();

        if ((int) $order->customer_id !== (int) $user->id) {
            abort(403);
        }

        $order->update(['customer_hidden_at' => now()]);

        return back()->with('success', 'Oda imeondolewa kwenye historia yako. Rekodi yake bado imehifadhiwa.');
    }

    public function restore(Order $order)
    {
        $user = Auth::user();

        if ((int) $order->customer_id !== (int) $user->id) {
            abort(403);
        }

        $order->update(['customer_hidden_at' => null]);

        return back()->with('success', 'Oda imerudishwa kwenye historia yako.');
    }

    public function getSettlement(Order $order, FinancialSettlementService $financialService)
    {
        $user = Auth::user();

        if ((int) $order->customer_id !== (int) $user->id && $user->role !== 'admin') {
            abort(403);
        }

        return response()->json(
            $financialService->getSettlementSummary($order)
        );
    }

    public function cancel(Order $order, FinancialSettlementService $financialService)
    {
        $user = Auth::user();

        if ((int) $order->customer_id !== (int) $user->id && $user->role !== 'admin') {
            abort(403);
        }

        if ($order->status === 'delivered') {
            return back()->with('error', 'Oda iliyokabidhiwa haiwezi kufutwa hapa.');
        }

        $financialService->cancelOrderAndRestoreStock($order);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Oda imeghairiwa na stock imerudishwa.');
    }
}