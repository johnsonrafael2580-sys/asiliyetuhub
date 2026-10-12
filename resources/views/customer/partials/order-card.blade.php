<div class="rounded-3xl bg-white border border-amber-900/10 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-amber-900/10 flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Order #{{ $order->id }}</p>
            <p class="font-heading font-bold text-lg text-[#3D2314] mt-1">{{ $order->created_at?->format('d M Y, H:i') }}</p>
        </div>
        @php
            $statusClasses = [
                'pending' => 'bg-amber-100 text-amber-900',
                'processing' => 'bg-blue-100 text-blue-800',
                'shipped' => 'bg-purple-100 text-purple-800',
                'delivered' => 'bg-green-100 text-green-800',
                'cancelled' => 'bg-red-100 text-red-800',
                'confirmed' => 'bg-blue-100 text-blue-800',
            ];
        @endphp
        <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-700' }}">{{ str_replace('_', ' ', ucfirst($order->status)) }}</span>
    </div>

    <div class="p-5 space-y-4">
        @foreach($order->items as $item)
            <div class="rounded-2xl bg-amber-50/60 border border-amber-100 p-4">
                <div class="flex justify-between gap-4">
                    <div>
                        <p class="font-bold text-[#3D2314]">{{ $item->product_title }}</p>
                        <p class="text-xs text-gray-500 mt-1">Qty: {{ $item->quantity }} · Artisan: {{ $item->artisan?->name ?? '—' }}</p>
                    </div>
                    <p class="font-bold text-amber-900">TZS {{ number_format($item->subtotal, 2) }}</p>
                </div>
                <div class="mt-3 flex items-center justify-between text-xs">
                    <span class="text-gray-500">Shipment status</span>
                    <span class="font-bold text-[#3D2314]">{{ str_replace('_', ' ', ucfirst($item->fulfillment_status ?? 'pending')) }}</span>
                </div>
            </div>
        @endforeach

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2">
            <div>
                <p class="text-xs text-gray-500">Total</p>
                <p class="text-xl font-heading font-black text-[#3D2314]">TZS {{ number_format($order->total_amount, 2) }}</p>
            </div>
            <div class="flex gap-2">
                @if($order->payment_status === 'processing')
                    <span class="rounded-xl bg-amber-100 text-amber-900 px-4 py-2 text-sm font-bold">Payment processing</span>
                @elseif($order->payment_status === 'failed')
                    <a href="{{ route('orders.payment', $order) }}" class="rounded-xl bg-rose-700 px-4 py-2 text-sm font-bold text-white hover:bg-rose-800">Retry payment</a>
                @elseif($order->payment_status === 'paid')
                    <span class="rounded-xl bg-emerald-100 text-emerald-800 px-4 py-2 text-sm font-bold">✓ Paid</span>
                @endif
                <a href="{{ route('orders.show', $order) }}" class="rounded-xl bg-[#3D2314] px-4 py-2 text-sm font-bold text-white hover:bg-[#2C180E]">Details</a>
            </div>
        </div>
    </div>
</div>