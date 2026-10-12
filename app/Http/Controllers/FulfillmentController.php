<?php

namespace App\Http\Controllers;

use App\Models\Fulfillment;
use App\Models\DeliveryTracking;
use App\Models\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommissionController;
use App\Services\ArtisanEarningsReconciliationService;
use App\Notifications\OrderStatusNotification;
use App\Services\FinancialSettlementService;
use App\Services\CustomerCommunicationService;

class FulfillmentController extends Controller
{
   
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'artisan') {
            $fulfillments = Fulfillment::where('artisan_id', $user->id)
                ->with(['productRequest.product', 'deliveryTracking'])
                ->latest()
                ->paginate(15);
        } elseif ($user->role === 'admin') {
            $fulfillments = Fulfillment::with(['productRequest.product', 'artisan', 'deliveryTracking'])
                ->latest()
                ->paginate(15);
        } else {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        return view('fulfillments.index', compact('fulfillments'));
    }

   
    public function create(ProductRequest $productRequest)
    {
        $product = $productRequest->product;
        $artisan = $product->artisan;

        if (Auth::user()->id !== $artisan->id && Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        return view('fulfillments.create', compact('productRequest', 'product', 'artisan'));
    }

   
    public function store(Request $request, ?ProductRequest $productRequest = null)
    {
        $orderId = $request->input('product_request_id', $productRequest?->id);
        $order = ProductRequest::with('product.artisan')->findOrFail($orderId);
        $product = $order->product;
        $artisan = $product->artisan;

        if (Auth::user()->id !== $artisan->id && Auth::user()->role !== 'admin') {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $request->validate([
            'courier_partner' => 'nullable|string',
            'packaging_notes' => 'nullable|string',
            'pickup_location' => 'required|string',
            'delivery_location' => 'required|string',
            'special_instructions' => 'nullable|string',
        ]);

        $fulfillment = Fulfillment::create([
            'product_request_id' => $order->id,
            'artisan_id' => $artisan->id,
            'courier_partner' => $request->courier_partner,
            'packaging_notes' => $request->packaging_notes,
            'pickup_location' => $request->pickup_location,
            'delivery_location' => $request->delivery_location,
            'special_instructions' => $request->special_instructions,
        ]);

        // Create initial tracking entry using a valid ENUM event type
        DeliveryTracking::create([
            'fulfillment_id' => $fulfillment->id,
            'event_type' => 'pending',
            'description' => 'Fulfillment initiated from ' . $request->pickup_location,
            'updated_by' => Auth::user()->name,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Fulfillment created successfully',
                'fulfillment' => $fulfillment,
            ]);
        }

        return redirect()->route('fulfillments.show', $fulfillment)
            ->with('success', 'Fulfillment created successfully');
    }

    
    public function show(Fulfillment $fulfillment)
    {
        if (Auth::user()->id !== $fulfillment->artisan_id && Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $fulfillment->load(['productRequest.product', 'artisan', 'deliveryTracking']);

        return view('fulfillments.show', compact('fulfillment'));
    }

    
    public function updateStatus(Request $request, Fulfillment $fulfillment, FinancialSettlementService $financialService, CustomerCommunicationService $communication)
    {
        if (Auth::user()->id !== $fulfillment->artisan_id && Auth::user()->role !== 'admin') {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $request->validate([
            'status' => 'required|in:pending,packaged,dispatched,in_transit,delivered,failed',
            'tracking_number' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $updates = [
            'status' => $request->status,
            'tracking_number' => $request->tracking_number ?? $fulfillment->tracking_number,
        ];

        if ($request->status === 'packaged') {
            $updates['packaged_at'] = now();
        } elseif ($request->status === 'dispatched') {
            $updates['dispatched_at'] = now();
        } elseif ($request->status === 'delivered') {
            $updates['delivered_at'] = now();
        }

        $fulfillment->update($updates);

        
        DeliveryTracking::create([
            'fulfillment_id' => $fulfillment->id,
            'event_type' => $request->status,
            'description' => $request->description ?? 'Status updated to ' . $request->status,
            'updated_by' => Auth::user()->name,
        ]);

       
        $productRequest = $fulfillment->productRequest;
        if ($productRequest) {
            $productRequest->update(['status' => $request->status]);

            if ($productRequest->orderItem) {
                $productRequest->orderItem->update([
                    'fulfillment_status' => $request->status,
                ]);
            }

            if ($productRequest->order) {
                $productRequest->order->syncStatusFromItems();
                $productRequest->order->load('customer');

                if ($productRequest->order->customer) {
                    $productRequest->order->customer->notify(new OrderStatusNotification(
                        $productRequest->order,
                        $request->status,
                        "Oda #{$productRequest->order->id} ya {$productRequest->product->title} sasa iko hatua ya " . str_replace('_', ' ', $request->status) . "."
                    ));

                    $communication->send(
                        $productRequest->order->customer->email,
                        $productRequest->order->customer->phone,
                        "Order #{$productRequest->order->id} status update",
                        "Asili Yetu Hub: order #{$productRequest->order->id} is now " . str_replace('_', ' ', $request->status) . ". Check your dashboard for tracking details."
                    );
                }

                if ($request->status === 'delivered' && $productRequest->order->payment_status === 'paid') {
                    $financialService->settlePaymentToArtisan($productRequest->order);
                    $customer = $productRequest->order->customer;
                    if ($customer) {
                        $communication->send(
                            $customer->email,
                            $customer->phone,
                            "Order #{$productRequest->order->id} delivered",
                            "Asili Yetu Hub: order #{$productRequest->order->id} has been marked delivered. Payment settlement was completed automatically."
                        );
                    }
                }
            }
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Fulfillment updated', 'fulfillment' => $fulfillment]);
        }

        return redirect()->back()->with('success', 'Fulfillment status updated to ' . ucfirst($request->status));
    }

   
    public function markDelivered(Request $request, Fulfillment $fulfillment, FinancialSettlementService $financialService, CustomerCommunicationService $communication)
    {
        if (Auth::user()->id !== $fulfillment->artisan_id && Auth::user()->role !== 'admin') {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            return redirect()->back()->with('error', 'Unauthorized');
        }

        $fulfillment->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        DeliveryTracking::create([
            'fulfillment_id' => $fulfillment->id,
            'event_type' => 'delivered',
            'description' => 'Artisan marked shipment as delivered. Settlement is processed automatically.',
            'updated_by' => Auth::user()->name,
        ]);

        $productRequest = $fulfillment->productRequest;

        if ($productRequest) {
            $productRequest->update(['status' => 'delivered']);

            if ($productRequest->orderItem) {
                $productRequest->orderItem->update([
                    'fulfillment_status' => 'delivered',
                ]);
            }

            if ($productRequest->order) {
                $productRequest->order->syncStatusFromItems();
                $productRequest->order->load('customer');

                if ($productRequest->order->customer) {
                    $productRequest->order->customer->notify(new OrderStatusNotification(
                        $productRequest->order,
                        'delivered',
                        "Oda #{$productRequest->order->id} imefika. Mfumo umefanya settlement automatically."
                    ));
                }

                if ($productRequest->order->payment_status === 'paid') {
                    $financialService->settlePaymentToArtisan($productRequest->order);
                    $customer = $productRequest->order->customer;
                    if ($customer) {
                        $communication->send(
                            $customer->email,
                            $customer->phone,
                            "Order #{$productRequest->order->id} delivered",
                            "Asili Yetu Hub: order #{$productRequest->order->id} has been delivered and settlement was completed automatically."
                        );
                    }
                }
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Shipment marked delivered and settlement processed automatically.',
                'fulfillment' => $fulfillment,
            ]);
        }

        return redirect()->back()->with(
            'success',
            'Shipment imewekwa delivered na settlement imefanyika automatically.'
        );
    }

}
