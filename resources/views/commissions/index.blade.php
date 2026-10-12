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
                <h2 class="font-heading font-black text-2xl text-amber-100 tracking-wide" data-en="Artisan Earnings & Commissions" data-sw="Mapato na Posho za Fundi">
                    Artisan Earnings & Commissions
                </h2>
                <p class="text-xs sm:text-sm text-amber-200/80 mt-1 font-medium" data-en="Fair, post-sale commission model — zero upfront registration fees." data-sw="Mfumo wa haki ambapo unalipa gharama ya huduma baada ya kuuza tu — hakuna malipo ya kujiandikisha">
                    Fair, post-sale commission model — zero upfront registration fees.
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
            
            <!-- Stats Overview Grid -->
            <div class="mb-5 rounded-2xl bg-emerald-50 border border-emerald-200 p-5">
                <p class="text-xs font-bold text-emerald-800" data-en="Available artisan balance" data-sw="Salio linalopatikana">Available artisan balance</p>
                <p class="text-2xl font-black text-emerald-900 mt-1">TZS {{ number_format(auth()->user()->wallet_balance ?? 0, 2) }}</p>
                <p class="text-xs text-emerald-700 mt-1" data-en="Automatically credited when an order is delivered." data-sw="Huongezwa moja kwa moja oda inapokabidhiwa.">Automatically credited when an order is delivered.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Total Earned -->
                <div class="p-6 bg-white rounded-2xl border border-amber-900/10 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-900 bg-amber-100 px-2.5 py-1 rounded-lg border border-amber-300" data-en="Completed Earnings" data-sw="Mapato Yaliyokamilika">
                            Completed Earnings
                        </span>
                    </div>
                    
                    <div class="mt-4">
                        <p class="text-xs text-gray-500 font-medium" data-en="Net Earned (Post-Commission)" data-sw="Mapato Halisi (Baada ya Gharama za Huduma za Mfumo)">Net Earned (Post-Commission)</p>
                        <h4 class="text-2xl font-black text-[#3D2314] mt-1">
                            TZS {{ number_format($stats['total_earned'] ?? 0, 2) }}
                        </h4>
                    </div>
                </div>

                
                <div class="p-6 bg-white rounded-2xl border border-amber-900/10 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-800 bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-200" data-en="In Delivery Pipeline" data-sw="Kwenye Usafirishaji">
                            In Delivery Pipeline
                        </span>
                    </div>
                    <div class="mt-4">
                        <p class="text-xs text-gray-500 font-medium" data-en="Pending Orders Commission" data-sw="Gharama ya Oda Zisizokamilika">Pending Orders Commission</p>
                        <h4 class="text-2xl font-black text-amber-900 mt-1">
                            TZS {{ number_format($stats['pending_commissions'] ?? 0, 2) }}
                        </h4>
                    </div>
                </div>

               
                <div class="p-6 bg-white rounded-2xl border border-amber-900/10 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-900 bg-amber-100/60 px-2.5 py-1 rounded-lg border border-amber-300" data-en="Successful Sales" data-sw="Mauzo Yaliyofanikiwa">
                            Successful Sales
                        </span>
                    </div>
                    <div class="mt-4">
                        <p class="text-xs text-gray-500 font-medium" data-en="Delivered Orders" data-sw="Oda Zilizowasilishwa">Delivered Orders</p>
                        <h4 class="text-2xl font-black text-[#3D2314] mt-1">
                            {{ $stats['completed_orders'] ?? 0 }}
                        </h4>
                    </div>
                </div>
            </div>

           
            <div class="p-6 sm:p-10 bg-white shadow-sm border border-amber-900/10 rounded-2xl space-y-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-amber-900/10 pb-4">
                    <div>
                        <h3 class="text-xl font-heading font-bold text-[#3D2314]" data-en="Commission & Earnings Breakdown" data-sw="Mchanganuo wa Gharama na Mapato">
                            Commission & Earnings Breakdown
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5" data-en="Transparent transaction logs for every item ordered and delivered." data-sw="Kumbukumbu za wazi kwa kila bidhaa iliyoagizwa na kuwasilishwa.">
                            Transparent transaction logs for every item ordered and delivered.
                        </p>
                    </div>
                </div>

                @if(!isset($commissions) || $commissions->isEmpty())
                    <div class="text-center py-12">
                        <span class="text-4xl block mb-2">🏷️</span>
                        <h4 class="text-base font-bold text-gray-800" data-en="No commission records yet" data-sw="Bado hakuna kumbukumbu za Gharama za Huduma">
                            No commission records yet
                        </h4>
                        <p class="text-xs text-gray-500 mt-1" data-en="Commissions will appear here automatically when customer orders are fulfilled." data-sw="Kumbukumbu zitaonekana hapa pindi wateja wanapoagiza na kupokea bidhaa.">
                            Commissions will appear here automatically when customer orders are fulfilled.
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="bg-amber-50 text-[#3D2314] uppercase text-xs">
                                <tr>
                                    <th class="p-3 rounded-l-xl" data-en="Date / ID" data-sw="Tarehe / Kitambulisho">Date / ID</th>
                                    <th class="p-3" data-en="Product" data-sw="Bidhaa">Product</th>
                                    <th class="p-3" data-en="Order Value" data-sw="Thamani ya Oda">Order Value</th>
                                    <th class="p-3" data-en="Platform Fee (10%)" data-sw="Gharama za Huduma ya Mfumo(10%)">Platform Fee (10%)</th>
                                    <th class="p-3" data-en="Your Net Earnings (90%)" data-sw="Mapato Yako (90%)">Your Net Earnings (90%)</th>
                                    <th class="p-3 rounded-r-xl" data-en="Status" data-sw="Hali">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-amber-950/5">
                                @foreach($commissions as $comm)
                                    <tr class="hover:bg-amber-50/40 transition">
                                        <td class="p-3 font-semibold text-gray-900">
                                            #{{ $comm->id }}<br>
                                            <span class="text-[11px] text-gray-400 font-normal">
                                                {{ $comm->created_at->format('M d, Y') }}
                                            </span>
                                        </td>
                                        <td class="p-3">
                                            <p class="font-bold text-gray-900">{{ $comm->product->title ?? 'Handcrafted Art' }}</p>
                                            <span class="text-xs text-amber-800">Order #{{ $comm->order_id }}</span>
                                        </td>
                                        <td class="p-3 font-semibold text-gray-900">
                                            TZS {{ number_format($comm->order_amount, 2) }}
                                        </td>
                                        <td class="p-3 text-amber-900 font-semibold">
                                            - TZS {{ number_format(($comm->order_amount * $comm->commission_rate) / 100, 2) }}
                                            <span class="text-[10px] text-gray-500 block">({{ $comm->commission_rate }}%)</span>
                                        </td>
                                        <td class="p-3 text-[#3D2314] font-bold">
                                            TZS {{ number_format($comm->commission_amount, 2) }}
                                        </td>
                                        <td class="p-3">
                                            @if($comm->status === 'completed')
                                                <span class="px-2.5 py-1 text-xs font-bold bg-amber-100 text-amber-900 rounded-full border border-amber-300">
                                                    ✓ Completed
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-bold bg-amber-50 text-amber-700 rounded-full border border-amber-200">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($commissions, 'hasPages') && $commissions->hasPages())
                        <div class="mt-6">
                            {{ $commissions->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
