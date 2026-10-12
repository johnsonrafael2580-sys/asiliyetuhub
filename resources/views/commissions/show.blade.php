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
                <h2 class="font-heading font-black text-2xl text-amber-100 tracking-wide" data-en="Commission Details" data-sw="Maelezo Gharama za Huduma">
                    Commission Details #{{ $commission->id }}
                </h2>
                <p class="text-xs sm:text-sm text-amber-200/80 mt-1 font-medium" data-en="Order breakdown and post-sale commission record" data-sw="Mchanganuo wa oda na kumbukumbu ya Gharama za Huduma">
                    Order breakdown and post-sale commission record
                </p>
            </div>

            <a href="{{ route('commissions.index') }}" class="px-4 py-2 text-xs font-bold text-amber-200 bg-amber-900/60 border border-amber-800/50 rounded-xl hover:bg-amber-900 transition flex items-center space-x-1 shadow-sm">
                <span>←</span>
                <span data-en="Back to Commissions" data-sw="Rudi kwenye Gharama za Huduma">Back to Commissions</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-wavy-pattern min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-6 sm:p-10 bg-white rounded-2xl border border-amber-900/10 shadow-sm space-y-6">
                <div class="border-b border-gray-100 pb-4 flex justify-between items-center">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-800">Transaction ID: COMM-{{ str_pad($commission->id, 5, '0', STR_PAD_LEFT) }}</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-1">{{ $commission->product->title ?? 'Handcrafted Art' }}</h3>
                    </div>
                    <div>
                        @if($commission->status === 'completed')
                            <span class="px-3 py-1 text-xs font-bold bg-emerald-100 text-emerald-800 rounded-full border border-emerald-300">
                                Completed
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-bold bg-amber-100 text-amber-800 rounded-full border border-amber-300">
                                Pending
                            </span>
                        @endif
                    </div>
                </div>

                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-5 bg-amber-50/50 rounded-xl border border-amber-900/10">
                    <div>
                        <span class="text-xs text-gray-500 font-semibold" data-en="Gross Order Value" data-sw="Jumla ya Thamani ya Oda">Gross Order Value</span>
                        <p class="text-lg font-bold text-gray-900 mt-1">TZS {{ number_format($commission->order_amount, 2) }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-red-600 font-semibold" data-en="Platform Fee (10%)" data-sw="Gharama za Huduma za Mfumo (10%)">Platform Fee (10%)</span>
                        <p class="text-lg font-bold text-red-700 mt-1">- TZS {{ number_format(($commission->order_amount * $commission->commission_rate) / 100, 2) }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-emerald-700 font-semibold" data-en="Net Earnings to Artisan" data-sw="Mapato Halisi ya Fundi">Net Earnings to Artisan</span>
                        <p class="text-xl font-black text-emerald-800 mt-1">TZS {{ number_format($commission->commission_amount, 2) }}</p>
                    </div>
                </div>

               
                <div class="space-y-3 text-sm text-gray-600 border-t border-gray-100 pt-4">
                    <div class="flex justify-between py-1">
                        <span class="font-medium">Order Number:</span>
                        <span class="font-semibold text-gray-900">#{{ $commission->order_id }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="font-medium">Created On:</span>
                        <span class="text-gray-900">{{ $commission->created_at->format('F d, Y h:i A') }}</span>
                    </div>
                    @if($commission->completed_at)
                    <div class="flex justify-between py-1">
                        <span class="font-medium">Completed On:</span>
                        <span class="text-gray-900">{{ \Carbon\Carbon::parse($commission->completed_at)->format('F d, Y h:i A') }}</span>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
