<x-app-layout>
    <style>
        @keyframes movePattern {
            0% { background-position: 0 0; }
            100% { background-position: 120px 120px; }
        }

        .bg-wavy-pattern {
            background-color: #FAF7F2;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 20 Q 25 5, 50 20 T 100 20 M0 50 Q 25 35, 50 50 T 100 50 M0 80 Q 25 65, 50 80 T 100 80' fill='none' stroke='%23854d0e' stroke-width='1' stroke-opacity='0.08'/%3E%3Cpath d='M20 0 Q 5 25, 20 50 T 20 100 M50 0 Q 35 25, 50 50 T 50 100 M80 0 Q 65 25, 80 50 T 80 100' fill='none' stroke='%23854d0e' stroke-width='1' stroke-opacity='0.06'/%3E%3C/svg%3E");
            background-size: 120px 120px;
            animation: movePattern 25s linear infinite;
        }
    </style>

    <x-slot name="header">
        <div class="bg-[#3D2314] -m-6 px-6 py-6 border-b border-amber-800/30 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-heading font-black text-2xl text-amber-100 tracking-wide" data-en="Live Shipment Tracker" data-sw="Ufuatiliaji wa Moja kwa Moja wa Mzigo">
                    Live Shipment Tracker #FUL-{{ str_pad($fulfillment->id, 4, '0', STR_PAD_LEFT) }}
                </h2>
                <p class="text-xs sm:text-sm text-amber-200/80 mt-1 font-medium" data-en="Real-time delivery progress from village workshop to customer." data-sw="Mwenendo wa ufikishaji kutoka kijijini hadi kwa mteja.">
                    Real-time delivery progress from village workshop to customer.
                </p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('fulfillments.index') }}" class="px-4 py-2 text-xs font-bold text-amber-200 bg-amber-900/60 border border-amber-800/50 rounded-xl hover:bg-amber-900 transition flex items-center space-x-1 shadow-sm">
                    <span>←</span>
                    <span data-en="All Shipments" data-sw="Mizigo Yote">All Shipments</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-wavy-pattern min-h-screen">
       
        <div class="w-full max-w-full px-4 sm:px-8 lg:px-12 space-y-8">
            
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-300 text-emerald-900 rounded-2xl text-sm font-semibold flex items-center space-x-2 shadow-sm">
                    <span>✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

           
            @php
                $steps = [
                    'pending' => ['label' => 'Initiated', 'icon' => '📝'],
                    'packaged' => ['label' => 'Packaged', 'icon' => '🎁'],
                    'dispatched' => ['label' => 'Dispatched', 'icon' => '🚚'],
                    'in_transit' => ['label' => 'In Transit', 'icon' => '🛣'],
                    'delivered' => ['label' => 'Delivered', 'icon' => '🎉'],
                ];
                $stepKeys = array_keys($steps);
                $currentIndex = array_search($fulfillment->status, $stepKeys);
                if ($currentIndex === false) { $currentIndex = 0; }
            @endphp

            <div class="p-6 sm:p-8 bg-white rounded-2xl border border-amber-900/10 shadow-sm space-y-6 w-full">
                <h3 class="text-sm font-bold uppercase tracking-wider text-[#3D2314]" data-en="Shipment Progression" data-sw="Hatua za Usafirishaji">
                    Shipment Progression
                </h3>

               
                <div class="relative flex items-center justify-between">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-amber-900/10 w-full z-0"></div>
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-[#3D2314] transition-all duration-500 z-0"
                         style="width: {{ count($stepKeys) > 1 ? ($currentIndex / (count($stepKeys) - 1)) * 100 : 0 }}%;"></div>

                    @foreach($steps as $key => $step)
                        @php
                            $stepIndex = array_search($key, $stepKeys);
                            $isPassed = $stepIndex <= $currentIndex;
                            $isCurrent = $stepIndex === $currentIndex;
                        @endphp
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 {{ $isPassed ? 'bg-[#3D2314] text-amber-100 shadow-md border border-amber-800/30' : 'bg-amber-50 text-amber-900/40 border border-amber-900/20' }} {{ $isCurrent ? 'ring-4 ring-amber-900/15 scale-110' : '' }}">
                                <span>{{ $step['icon'] }}</span>
                            </div>
                            <span class="text-xs font-bold mt-2 capitalize {{ $isPassed ? 'text-[#3D2314] font-bold' : 'text-amber-900/40' }}">
                                {{ $step['label'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

           
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 w-full">
                
               
                <div class="lg:col-span-4 space-y-6">
                    <div class="p-6 sm:p-8 bg-white rounded-2xl border border-amber-900/10 shadow-sm space-y-5">
                        <h4 class="font-heading font-bold text-[#3D2314] text-base border-b border-amber-900/10 pb-3" data-en="Routing Information" data-sw="Taarifa za Safari">
                            Routing Information
                        </h4>

                       
                        <div>
                            <span class="text-[11px] font-bold uppercase text-amber-900/60">Craft / Item</span>
                            <p class="font-bold text-amber-950 text-base mt-0.5">
                                {{ $fulfillment->productRequest->product->title ?? 'Cultural Product' }}
                            </p>
                            <span class="text-xs text-amber-900/70 font-semibold bg-amber-50 px-2 py-0.5 rounded border border-amber-900/10 inline-block mt-1">Order #{{ $fulfillment->product_request_id }}</span>
                        </div>

                       
                        <div class="pt-3 border-t border-amber-900/10">
                            <span class="text-[11px] font-bold uppercase text-[#3D2314] flex items-center gap-1">
                                <span>📍</span> Pickup (Rural Village)
                            </span>
                            <p class="text-xs font-semibold text-amber-950 mt-1">
                                {{ $fulfillment->pickup_location }}
                            </p>
                        </div>

                       
                        <div class="pt-3 border-t border-amber-900/10">
                            <span class="text-[11px] font-bold uppercase text-[#3D2314] flex items-center gap-1">
                                <span>🏨</span> Destination (Tourist)
                            </span>
                            <p class="text-xs font-semibold text-amber-950 mt-1">
                                {{ $fulfillment->delivery_location }}
                            </p>
                        </div>

                       
                        <div class="pt-3 border-t border-amber-900/10">
                            <span class="text-[11px] font-bold uppercase text-amber-900/60">Carrier & Tracking</span>
                            <p class="text-xs font-bold text-amber-950 mt-1">
                                {{ $fulfillment->courier_partner ?? 'Direct Village Carrier' }}
                            </p>
                            @if($fulfillment->tracking_number)
                                <p class="text-xs font-mono font-bold text-amber-900 bg-amber-50 p-2 rounded-lg border border-amber-900/20 mt-2 inline-block">
                                    {{ $fulfillment->tracking_number }}
                                </p>
                            @endif
                        </div>

                        @if($fulfillment->special_instructions)
                        <div class="pt-3 border-t border-amber-900/10">
                            <span class="text-[11px] font-bold uppercase text-red-700">Special Instructions</span>
                            <p class="text-xs text-amber-950/80 mt-1 bg-red-50/50 p-3 rounded-xl border border-red-200/40 font-medium leading-relaxed">
                                {{ $fulfillment->special_instructions }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

               
                <div class="lg:col-span-8 space-y-6">
                    
                    
                    @if($fulfillment->status !== 'delivered')
                    <div class="p-6 sm:p-8 bg-white rounded-2xl border border-amber-900/10 shadow-sm space-y-6 w-full">
                        <h4 class="font-heading font-bold text-[#3D2314] text-lg border-b border-amber-900/10 pb-3" data-en="Post Status Update" data-sw="Weka Maendeleo Mapya">
                            Post Status Update / Weka Maendeleo
                        </h4>

                        <form action="{{ route('fulfillments.update-status', $fulfillment->id) }}" method="POST" class="space-y-6 w-full">
                            @csrf
                            @method('PATCH')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                                <div class="w-full">
                                    <label class="block text-xs font-bold text-[#3D2314] uppercase mb-2 tracking-wide">New Stage *</label>
                                    <select name="status" required class="block w-full rounded-xl border-amber-900/20 bg-amber-50/20 text-sm font-bold text-amber-950 focus:border-amber-700 focus:ring-amber-800 py-3 px-4 transition">
                                        <option value="packaged" {{ $fulfillment->status === 'packaged' ? 'selected' : '' }}>🎁 Packaged in Workshop</option>
                                        <option value="dispatched" {{ $fulfillment->status === 'dispatched' ? 'selected' : '' }}>🚚 Dispatched to Courier</option>
                                        <option value="in_transit" {{ $fulfillment->status === 'in_transit' ? 'selected' : '' }}>🛣️ In Transit (On Highway)</option>
                                        <option value="delivered" {{ $fulfillment->status === 'delivered' ? 'selected' : '' }}>🎉 Delivered to Tourist</option>
                                    </select>
                                </div>

                                <div class="w-full">
                                    <label class="block text-xs font-bold text-[#3D2314] uppercase mb-2 tracking-wide">Tracking Number</label>
                                    <input type="text" name="tracking_number" value="{{ $fulfillment->tracking_number }}" placeholder="e.g. EMS-992384"
                                        class="block w-full rounded-xl border-amber-900/20 bg-amber-50/20 text-sm font-bold text-amber-950 focus:border-amber-700 focus:ring-amber-800 py-3 px-4 transition">
                                </div>
                            </div>

                            <div class="w-full">
                                <label class="block text-xs font-bold text-[#3D2314] uppercase mb-2 tracking-wide">Checkpoint Note / Description</label>
                                <input type="text" name="description" placeholder="e.g. Package collected by Posta van in Arusha; expected at hotel by 4 PM"
                                    class="block w-full rounded-xl border-amber-900/20 bg-amber-50/20 text-sm text-amber-950 focus:border-amber-700 focus:ring-amber-800 py-3 px-4 transition">
                            </div>

                            <div class="flex flex-wrap justify-end items-center pt-2 gap-4">
                                <button type="submit" class="px-6 py-3 bg-[#3D2314] hover:bg-[#2C180E] text-amber-100 text-xs font-bold rounded-xl transition shadow-md border border-amber-800/30">
                                    Update Stage
                                </button>
                            </div>
                        </form>

                        <div class="pt-4 border-t border-amber-900/10">
                            <form action="{{ route('fulfillments.mark-delivered', $fulfillment->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Confirm order has been safely received by tourist?')"
                                    class="w-full px-6 py-3 bg-[#3D2314] hover:bg-[#2C180E] text-amber-100 text-xs font-bold rounded-xl transition shadow-md border border-amber-800/30 text-center">
                                    ✓ Mark Fully Delivered
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="p-6 bg-amber-50/70 border border-amber-900/20 rounded-2xl flex items-center space-x-4 text-[#3D2314]">
                        <span class="text-3xl">🎉</span>
                        <div>
                            <h4 class="font-bold text-base" data-en="Order Safely Delivered" data-sw="Mzigo Umewasilishwa">Order Safely Delivered</h4>
                            <p class="text-xs text-amber-900/80 leading-relaxed mt-1" data-en="The customer received their handcrafted goods. Corresponding 10% platform commission is finalized and net funds are credited to your wallet balance." data-sw="Mteja amepokea bidhaa yake. Tume ya 10% imekamilishwa na salio halisi limeingizwa kwenye pochi yako ya kutoa.">
                                The customer received their handcrafted goods. Corresponding 10% platform commission is finalized and net funds are credited to your wallet balance.
                            </p>
                        </div>
                    </div>
                    @endif

                    <!-- Chronological Delivery Tracking Event Log -->
                    <div class="p-6 sm:p-8 bg-white rounded-2xl border border-amber-900/10 shadow-sm space-y-6 w-full">
                        <h4 class="font-heading font-bold text-[#3D2314] text-lg border-b border-amber-900/10 pb-3" data-en="Live Tracking Event Log" data-sw="Kumbukumbu za Ufuatiliaji">
                            Live Tracking Event Log
                        </h4>

                        @if($fulfillment->deliveryTracking->isEmpty())
                            <p class="text-xs text-amber-900/60 py-4" data-en="No tracking events logged yet." data-sw="Bado hakuna matukio yaliyorekodiwa.">
                                No tracking events logged yet.
                            </p>
                        @else
                            <div class="space-y-4 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-amber-900/10">
                                @foreach($fulfillment->deliveryTracking->reverse() as $track)
                                    <div class="relative flex items-start space-x-3 pl-1">
                                        <div class="w-6 h-6 rounded-full bg-[#3D2314] text-amber-100 flex items-center justify-center text-[10px] font-bold z-10 shrink-0 border border-amber-800/30">
                                            ✓
                                        </div>
                                        <div class="flex-1 bg-amber-50/30 p-4 rounded-xl border border-amber-900/10 space-y-1">
                                            <div class="flex justify-between items-center text-xs">
                                                <span class="font-bold uppercase text-amber-900 tracking-wider">
                                                    {{ str_replace('_', ' ', $track->event_type) }}
                                                </span>
                                                <span class="text-[11px] text-amber-900/50">
                                                    {{ $track->created_at->format('M d, Y - h:i A') }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-amber-950 font-medium">{{ $track->description }}</p>
                                            <span class="text-[10px] text-amber-900/50 block pt-1">Logged by: {{ $track->updated_by ?? 'System' }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
