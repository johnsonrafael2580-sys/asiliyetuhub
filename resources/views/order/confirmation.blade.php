
<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-heading font-bold text-2xl text-amber-100">Order #{{ $order->id }} Created</h2>
            <p class="text-sm text-amber-200/80">Payment yako inachakatwa automatically na provider.</p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <div class="rounded-3xl bg-green-50 border border-green-200 p-6">
            <h1 class="font-heading font-black text-2xl text-green-900">Oda imeandaliwa kwa mafanikio.</h1>
            <p class="text-sm text-green-800 mt-2">Hakuna request iliyotumwa kwa artisan bado. Malipo lazima yatolewe na kuthibitishwa kwanza.</p>
        </div>

        <div class="rounded-3xl bg-white border border-amber-900/10 shadow-sm p-6">
            <h3 class="font-heading font-bold text-xl text-[#3D2314] mb-5">Order Details</h3>
            @foreach($order->items as $item)
                <div class="flex justify-between gap-4 py-3 border-b border-gray-100 last:border-0">
                    <div>
                        <p class="font-bold text-[#3D2314]">{{ $item->product_title }}</p>
                        <p class="text-xs text-gray-500">Qty {{ $item->quantity }}</p>
                    </div>
                    <p class="font-bold">TZS {{ number_format($item->subtotal, 2) }}</p>
                </div>
            @endforeach
            <div class="flex justify-between mt-5 pt-4 border-t font-black text-[#3D2314]">
                <span>Total</span>
                <span>TZS {{ number_format($pricingBreakdown['total_charged'], 2) }}</span>
            </div>
        </div>

        <div class="rounded-3xl bg-amber-50 border border-amber-200 p-6">
            <h3 class="font-heading font-bold text-xl text-[#3D2314]">Payment Required</h3>
            <p class="text-sm text-amber-900 mt-2">Lipa TZS {{ number_format($pricingBreakdown['total_charged'], 2) }} kupitia automatic mobile-money prompt. Payment ita-confirmiwa na provider bila admin verification.</p>
            <a href="{{ route('orders.payment', $order) }}" class="inline-block mt-5 rounded-xl bg-[#3D2314] text-white font-bold px-5 py-3 hover:bg-[#2C180E]">Endelea kwenye Payment</a>
        </div>
    </div>
</x-app-layout>