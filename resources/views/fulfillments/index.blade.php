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
                <h2 class="font-heading font-black text-2xl text-amber-100 tracking-wide" data-en="Order Fulfillment & Delivery Pipeline" data-sw="Usafirishaji na Ufikishaji wa Mizigo">
                    Order Fulfillment & Delivery Pipeline
                </h2>
                <p class="text-xs sm:text-sm text-amber-200/80 mt-1 font-medium" data-en="Track handcrafted items from rural villages directly to tourists and customers in real-time." data-sw="Fuatilia safari ya bidhaa kutoka vijijini moja kwa moja hadi kwa watalii na wanunuzi.">
                    Track handcrafted items from rural villages directly to tourists and customers in real-time.
                </p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('artisan.dashboard') }}" class="px-4 py-2 text-xs font-bold text-amber-200 bg-amber-900/60 border border-amber-800/50 rounded-xl hover:bg-amber-900 transition flex items-center space-x-1 shadow-sm">
                    <span>←</span>
                    <span data-en="Back to Dashboard" data-sw="Rudi Dashibodi">Back to Dashboard</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-wavy-pattern min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-300 text-emerald-900 rounded-2xl text-sm font-semibold flex items-center space-x-2">
                    <span>✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            
            <div class="p-6 sm:p-10 bg-white shadow-sm border border-amber-900/10 rounded-2xl space-y-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-amber-900/10 pb-4">
                    <div>
                        <h3 class="text-xl font-heading font-bold text-[#3D2314]" data-en="Active Shipments & Orders" data-sw="Mizigo Inayosafirishwa">
                            Active Shipments & Orders
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5" data-en="Complete audit trail and current shipment state for each order." data-sw="Kumbukumbu kamili na hali ya safari ya kila mzigo.">
                            Complete audit trail and current shipment state for each order.
                        </p>
                    </div>
                </div>

                @if($fulfillments->isEmpty())
                    <div class="text-center py-12">
                        <h4 class="text-base font-bold text-gray-800" data-en="No shipments in progress" data-sw="Hakuna mizigo inayosafirishwa kwa sasa">
                            No shipments in progress
                        </h4>
                        <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto" data-en="When customers request items on your dashboard, click 'Ship Order' to create a fulfillment tracking pipeline." data-sw="Wateja wanapoagiza bidhaa kwenye dashibodi yako, bonyeza 'Safirisha' kuanzisha ufuatiliaji wa mzigo.">
                            When customers request items on your dashboard, click 'Ship Order' to create a fulfillment tracking pipeline.
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="bg-amber-50 text-[#3D2314] uppercase text-xs">
                                <tr>
                                    <th class="p-3 rounded-l-xl" data-en="Fulfillment ID" data-sw="Kitambulisho">Fulfillment ID</th>
                                    <th class="p-3" data-en="Craft / Item" data-sw="Bidhaa">Craft / Item</th>
                                    <th class="p-3" data-en="Pickup (Village)" data-sw="Kituo cha Kuchukua">Pickup (Village)</th>
                                    <th class="p-3" data-en="Destination (Tourist)" data-sw="Kituo cha Kufikisha">Destination (Tourist)</th>
                                    <th class="p-3" data-en="Courier / Tracking" data-sw="Msafirishaji / Namba">Courier / Tracking</th>
                                    <th class="p-3" data-en="Current Status" data-sw="Hali ya Safari">Current Status</th>
                                    <th class="p-3 rounded-r-xl" data-en="Actions" data-sw="Hatua">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-amber-950/5">
                                @foreach($fulfillments as $f)
                                    <tr class="hover:bg-amber-50/40 transition">
                                        <td class="p-3 font-semibold text-gray-900">
                                            #FUL-{{ str_pad($f->id, 4, '0', STR_PAD_LEFT) }}<br>
                                            <span class="text-[11px] text-gray-400 font-normal">
                                                {{ $f->created_at->format('M d, Y') }}
                                            </span>
                                        </td>
                                        <td class="p-3">
                                            <p class="font-bold text-gray-900">{{ $f->productRequest->product->title ?? 'Cultural Handcraft' }}</p>
                                            <span class="text-xs text-amber-800">Order #{{ $f->product_request_id }}</span>
                                        </td>
                                        <td class="p-3 text-xs text-gray-700">
                                             {{ $f->pickup_location }}
                                        </td>
                                        <td class="p-3 text-xs text-gray-700">
                                            {{ $f->delivery_location }}
                                        </td>
                                        <td class="p-3 text-xs">
                                            <span class="font-bold text-gray-900">{{ $f->courier_partner ?? 'Local Courier' }}</span>
                                            @if($f->tracking_number)
                                                <span class="block font-mono text-[11px] text-amber-800">{{ $f->tracking_number }}</span>
                                            @endif
                                        </td>
                                        <td class="p-3">
                                            @if($f->status === 'delivered')
                                                <span class="px-2.5 py-1 text-xs font-bold bg-emerald-100 text-emerald-800 rounded-full border border-emerald-300">
                                                    ✓ Delivered
                                                </span>
                                            @elseif($f->status === 'in_transit')
                                                <span class="px-2.5 py-1 text-xs font-bold bg-blue-100 text-blue-800 rounded-full border border-blue-300">
                                                     In Transit
                                                </span>
                                            @elseif($f->status === 'dispatched')
                                                <span class="px-2.5 py-1 text-xs font-bold bg-purple-100 text-purple-800 rounded-full border border-purple-300">
                                                    Dispatched
                                                </span>
                                            @elseif($f->status === 'packaged')
                                                <span class="px-2.5 py-1 text-xs font-bold bg-amber-100 text-amber-800 rounded-full border border-amber-300">
                                                    Packaged
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-bold bg-gray-100 text-gray-800 rounded-full border border-gray-300">
                                                     Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="p-3">
                                            <a href="{{ route('fulfillments.show', $f->id) }}" class="px-3 py-1.5 bg-[#3D2314] hover:bg-[#2C180E] text-amber-100 text-xs font-bold rounded-xl transition inline-flex items-center space-x-1 shadow-sm">
                                                <span>Track & Update</span>
                                                <span>→</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($fulfillments, 'hasPages') && $fulfillments->hasPages())
                        <div class="mt-6">
                            {{ $fulfillments->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
