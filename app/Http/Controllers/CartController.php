<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\FinancialSettlementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Services\AutomaticPaymentService;

class CartController extends Controller
{
    public function __construct(
        private FinancialSettlementService $financialService,
        private AutomaticPaymentService $automaticPaymentService
    ) {}

    public function emptyCart()
    {
        session()->forget('cart');

        return redirect()->route('cart.index')
            ->with('success', 'Kapu lako limefutwa kikamilifu.');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $enhancedCart = [];

        foreach ($cart as $id => $details) {
            $product = Product::find($id);

            if ($product) {
                $normalizedPrice = (float) ($details['base_price'] ?? $details['price'] ?? $product->price);

                $enhancedCart[$id] = array_merge($details, [
                    'price' => $normalizedPrice,
                    'base_price' => $normalizedPrice,
                    'shipping_fee' => 0,
                    'stock_available' => $product->stock_quantity,
                    'stock_status' => $product->getStockStatusAttribute(),
                    'in_stock' => $product->isInStock(),
                ]);
            }
        }

        $orders = collect();

        if (auth()->check() && Schema::hasColumn('orders', 'customer_id')) {
            $orders = Order::with(['items.product', 'items.artisan'])
                ->where('customer_id', auth()->id())
                ->whereNull('customer_hidden_at')
                ->latest()
                ->get();
        }

        return view('cart.index', compact('enhancedCart', 'orders'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);

        if ($product->stock_quantity <= 0) {
            return $this->respondError('Bidhaa hii haina stock kwa sasa.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] >= $product->stock_quantity) {
                return $this->respondError('Idadi imezidi. Stock iliyobaki: ' . $product->stock_quantity);
            }

            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'title' => $product->title ?? $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'base_price' => $product->base_price ?? $product->price,
                'shipping_fee' => 0,
                'image' => $product->image_path ?? null,
            ];
        }

        session()->put('cart', $cart);

        $totalItems = array_sum(array_column($cart, 'quantity'));

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Bidhaa imewekwa kwenye kikapu.',
                'cartCount' => $totalItems,
                'stockRemaining' => max(0, $product->stock_quantity - $cart[$id]['quantity']),
            ]);
        }

        return back()->with('success', 'Bidhaa imewekwa kwenye kikapu.');
    }

    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Bidhaa imeondolewa kwenye kikapu.');
    }

   
    public function checkout(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Tafadhali login au register kabla ya kutuma oda.');
        }

        $user = auth()->user();

        if (!in_array($user->role, ['customer', 'tourist'], true)) {
            return redirect()->route('dashboard')
                ->with('error', 'Akaunti hii si ya customer.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Kikapu chako kiko wazi.');
        }

        $validated = $request->validate([
            'delivery_location' => ['required', 'string', 'max:255'],
            'order_note' => ['nullable', 'string', 'max:2000'],
        ]);

        try {
            foreach ($cart as $id => $details) {
                $product = Product::find($id);

                if (!$product) {
                    throw new \Exception('One of the items in your cart no longer exists.');
                }

                $quantity = (int) ($details['quantity'] ?? 1);
                if ($product->stock_quantity < $quantity) {
                    throw new \Exception('"' . $product->title . '" has only ' . max(0, (int) $product->stock_quantity) . ' item(s) left in stock.');
                }
            }

            DB::transaction(function () use ($user, $cart, $validated, &$order) {
                $orderData = [
                    'customer_id' => $user->id,
                    'customer_name' => $user->name,
                    'customer_phone' => $user->phone ?? 'N/A',
                    'customer_email' => $user->email,
                    'total_amount' => 0,
                    'status' => 'pending',
                    'payment_method' => 'mobile_money',
                    'payment_status' => 'pending',
                    'escrow_status' => 'awaiting_payment',
                ];

                if (Schema::hasColumn('orders', 'customer_note')) {
                    $orderData['customer_note'] = $validated['order_note'] ?? null;
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

                $cartItems = [];

                foreach ($cart as $id => $details) {
                    $cartItems[$id] = [
                        'quantity' => (int) ($details['quantity'] ?? 1),
                        'description' => $validated['order_note'] ?? null,
                    ];
                }

                $this->financialService->createOrderItemsWithPricingBreakdown($order, $cartItems);
            });

            session()->forget('cart');
            $this->automaticPaymentService->initiate($order);

            return redirect()->route('orders.payment', $order)
                ->with('success', 'Payment prompt imetumwa kwenye simu yako. Hakuna transaction ID au admin verification inayohitajika.');
        } catch (\Throwable $e) {
            Log::error('Checkout order reservation failed', [
                'customer_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('cart.index')
                ->with('error', $e->getMessage() ?: 'Oda haikuweza kuandaliwa. Tafadhali hakikisha stock ipo kisha jaribu tena.');
        }
    }

    public function confirmation($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);

        if ((int) $order->customer_id !== (int) auth()->id()) {
            abort(403);
        }

        $pricingBreakdown = $this->financialService->getPricingBreakdown($order);

        return view('order.confirmation', compact('order', 'pricingBreakdown'));
    }

    private function respondError($message)
    {
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 400);
        }

        return back()->with('error', $message);
    }
}
