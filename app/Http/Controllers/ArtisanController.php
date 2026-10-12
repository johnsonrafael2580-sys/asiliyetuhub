<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\ProductRequest;
use App\Notifications\OrderStatusNotification;
use App\Services\FinancialSettlementService;
use App\Services\CustomerCommunicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ArtisanController extends Controller
{
    
    public function show($id)
    {
        $product = Product::with('user')->findOrFail($id);

        // Fair-Trade Breakdown
        $basePrice = $product->price;
        $commissionRate = 10 / 100;

        $platformFee = $basePrice * ($commissionRate / (1 - $commissionRate));
        $totalPrice = $basePrice + $platformFee;

        $fairTradeBreakdown = [
            'artist_earnings' => $basePrice,
            'platform_fee'    => $platformFee,
            'total_price'     => $totalPrice,
        ];

        return view(
            'products.show',
            compact('product', 'fairTradeBreakdown')
        );
    }


   
    public function updateOrderStatus(Request $request, $id, FinancialSettlementService $financialService, CustomerCommunicationService $communication)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,packaged,processing,dispatched,in_transit,out_for_delivery,delivered,cancelled'],
        ]);

        $productRequest = ProductRequest::with([
            'product',
            'customer',
            'orderItem',
            'order',
            'fulfillment',
        ])->findOrFail($id);

        if (
            $productRequest->product &&
            (int) $productRequest->product->user_id !== (int) auth()->id() &&
            auth()->user()->role !== 'admin'
        ) {
            abort(403, 'Unauthorized action.');
        }

        $status = $validated['status'];

        $productRequest->update([
            'status' => $status,
        ]);

        if ($productRequest->orderItem) {
            $productRequest->orderItem->update([
                'fulfillment_status' => $status,
            ]);
        }

        if ($productRequest->order) {
            $productRequest->order->syncStatusFromItems();
            $productRequest->order->load('customer');

            if ($productRequest->order->customer) {
                $label = str_replace('_', ' ', $status);

                $productRequest->order->customer->notify(new OrderStatusNotification(
                    $productRequest->order,
                    $status,
                    "Oda #{$productRequest->order->id} ya {$productRequest->product->title} sasa iko hatua ya {$label}."
                ));

                $communication->send(
                    $productRequest->order->customer->email,
                    $productRequest->order->customer->phone,
                    "Order #{$productRequest->order->id} status update",
                    "Asili Yetu Hub: order #{$productRequest->order->id} is now {$label}. Check your dashboard for tracking details."
                );
            }

            if ($status === 'delivered' && $productRequest->order->payment_status === 'paid') {
                $financialService->settlePaymentToArtisan($productRequest->order);
            }
        }

        Log::info('Artisan updated paid product request status', [
            'product_request_id' => $productRequest->id,
            'order_id' => $productRequest->order_id,
            'order_item_id' => $productRequest->order_item_id,
            'artisan_id' => auth()->id(),
            'status' => $status,
        ]);

        return redirect()->back()->with(
            'success',
            'Status ya bidhaa imebadilishwa na customer ataona update kwenye dashboard yake.'
        );
    }


   
    public function index(Request $request)
    {
       
        $products = Product::where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->paginate(
            9,
            ['*'],
            'products_page'
        );


        
        $query = \App\Models\ProductRequest::whereHas(
            'product',
            function ($q) {
                $q->where(
                    'user_id',
                    auth()->id()
                );
            }
        )
        ->with([
            'product',
            'customer',
            'fulfillment'
        ])
        ->latest();


       
        if (
            $request->filled('status')
        ) {
            $query->where(
                'status',
                $request->status
            );
        }


        $productRequests = $query
            ->paginate(
                10,
                ['*'],
                'orders_page'
            )
            ->appends(
                $request->query()
            );

       
        $artisanNotifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(5, ['*'], 'notifications_page')
            ->appends($request->except('notifications_page'));

        $artisanUnreadCount = auth()->user()
            ->unreadNotifications()
            ->count();

        return view(
            'artisan.dashboard',
            compact(
                'products',
                'productRequests',
                'artisanNotifications',
                'artisanUnreadCount'
            )
        );
    }


    
    public function storeProduct(Request $request)
    {
        if (Auth::user()->role !== 'artisan') {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'description' => [
                'required',
                'string'
            ],

            'story' => [
                'nullable',
                'string'
            ],

            'price' => [
                'required',
                'numeric',
                'min:0'
            ],

            'base_price' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'shipping_fee' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'stock_quantity' => [
                'required',
                'integer',
                'min:0'
            ],

            'category' => [
                'required',
                'string'
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048'
            ],
        ]);


        $imagePath = null;


       
        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $filename =
                time()
                . '_'
                . uniqid()
                . '.'
                . $file->getClientOriginalExtension();


            $destinationPath =
                public_path(
                    'assets/uploads'
                );


            if (!File::exists($destinationPath)) {

                File::makeDirectory(
                    $destinationPath,
                    0755,
                    true,
                    true
                );
            }


            $file->move(
                $destinationPath,
                $filename
            );


            $imagePath = $filename;
        }


        /*
         * Calculate pricing.
         */
        $totalPrice = $request->price;

        $basePrice =
            $request->base_price
            ?? ($totalPrice * 0.833);

        $shippingFee =
            $request->shipping_fee
            ?? ($totalPrice * 0.167);


        try {

            $product = Product::create([
                'user_id' =>
                    Auth::id(),

                'title' =>
                    $request->title,

                'description' =>
                    $request->description,

                'story' =>
                    $request->story,

                'price' =>
                    $totalPrice,

                'base_price' =>
                    $basePrice,

                'shipping_fee' =>
                    $shippingFee,

                'stock_quantity' =>
                    $request->stock_quantity,

                'platform_commission_rate' =>
                    10,

                'category' =>
                    $request->category,

                'image_path' =>
                    $imagePath,
            ]);


            /*
             * Product uploaded notification.
             */
            try {

                Auth::user()->notify(
                    new \App\Notifications\ProductUploadedNotification(
                        $product
                    )
                );

            } catch (\Exception $nex) {

                Log::warning(
                    'Failed to send product uploaded notification: '
                    . $nex->getMessage()
                );
            }


            return redirect()
                ->route('artisan.dashboard')
                ->with(
                    'success',
                    'Product uploaded successfully! / Bidhaa imepakiwa kwa mafanikio.'
                );

        } catch (\Exception $e) {

            Log::error(
                'Product upload failed: '
                . $e->getMessage(),
                [
                    'exception' => $e
                ]
            );


            return redirect()
                ->route('artisan.dashboard')
                ->with(
                    'error',
                    'Product upload failed. Please try again and contact support if the problem persists.'
                );
        }
    }


    
    public function store(Request $request)
    {
        return redirect()
            ->route('artisan.dashboard')
            ->with(
                'success',
                'Product uploaded successfully! / Bidhaa imepakiwa mafanikio!'
            );
    }


   
    public function destroyProduct(Product $product)
    {
        if (
            Auth::id() !== $product->user_id
        ) {
            abort(
                403,
                'Unauthorized access.'
            );
        }


        if ($product->image_path) {

            $oldImagePath =
                public_path(
                    'assets/uploads/'
                    . $product->image_path
                );


            if (File::exists($oldImagePath)) {

                File::delete(
                    $oldImagePath
                );
            }
        }


        $product->delete();


        return redirect()
            ->route('artisan.dashboard')
            ->with(
                'success',
                'Product deleted successfully.'
            );
    }


   
    public function storeReview(
        Request $request,
        Product $product
    ) {
        $request->validate([
            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5'
            ],

            'comment' => [
                'nullable',
                'string',
                'max:500'
            ],
        ]);


        $existingReview =
            \App\Models\Review::where(
                'product_id',
                $product->id
            )
            ->where(
                'user_id',
                auth()->id()
            )
            ->first();


        if ($existingReview) {

            return back()
                ->with(
                    'error',
                    'Umeshawahi kutoa maoni kwenye bidhaa hii.'
                );
        }


        \App\Models\Review::create([
            'product_id' =>
                $product->id,

            'user_id' =>
                auth()->id(),

            'rating' =>
                $request->rating,

            'comment' =>
                $request->comment,
        ]);


        return back()
            ->with(
                'success',
                'Asante! Maoni yako yametumwa kwa mafanikio.'
            );
    }
}
