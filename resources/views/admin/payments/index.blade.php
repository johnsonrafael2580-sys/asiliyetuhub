<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[.2em] text-amber-300 font-bold">Operations center</p>
            <h2 class="font-heading font-black text-2xl sm:text-3xl text-amber-50">Marketplace Overview</h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-[#FAF7F2] px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach([
                    ['Orders', $stats['orders']],
                    ['Paid automatically', $stats['paid']],
                    ['Processing', $stats['processing']],
                    ['In transit', $stats['shipping']],
                    ['Delivered', $stats['delivered']],
                ] as [$label, $value])
                    <div class="rounded-2xl bg-white border border-amber-900/10 p-5 shadow-sm">
                        <p class="text-[10px] uppercase tracking-wider font-bold text-gray-400">{{ $label }}</p>
                        <p class="mt-2 text-2xl font-black text-[#3D2314]">{{ number_format($value) }}</p>
                    </div>
                @endforeach
            </div>

            <div class="rounded-3xl bg-white border border-amber-900/10 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h3 class="font-heading font-black text-xl text-[#3D2314]">Automatic payment activity</h3>
                        <p class="text-xs text-gray-500 mt-1">Read-only audit trail. Payment status comes from Africa's Talking callbacks.</p>
                    </div>
                    <span class="rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 px-3 py-1.5 text-xs font-bold">No manual verification</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-[10px] uppercase tracking-wider text-gray-500">
                            <tr><th class="px-5 py-3 text-left">Order</th><th class="px-5 py-3 text-left">Customer</th><th class="px-5 py-3 text-left">Amount</th><th class="px-5 py-3 text-left">Provider</th><th class="px-5 py-3 text-left">Status</th><th class="px-5 py-3 text-left">Time</th></tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-amber-50/40">
                                <td class="px-5 py-4 font-bold text-[#3D2314]">#{{ $payment->order_id }}</td>
                                <td class="px-5 py-4">{{ $payment->customer?->name ?? '—' }}</td>
                                <td class="px-5 py-4 font-bold">TZS {{ number_format($payment->amount, 2) }}</td>
                                <td class="px-5 py-4">Africa's Talking<br><span class="text-[10px] text-gray-400">{{ $payment->provider_transaction_id ?? $payment->checkout_request_id ?? 'pending callback' }}</span></td>
                                <td class="px-5 py-4"><span class="rounded-full px-2.5 py-1 text-[10px] font-bold {{ $payment->status === 'verified' ? 'bg-emerald-100 text-emerald-800' : ($payment->status === 'failed' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">{{ $payment->status === 'verified' ? 'PAID' : strtoupper($payment->status) }}</span></td>
                                <td class="px-5 py-4 text-gray-500">{{ $payment->created_at?->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-12 text-center text-gray-500">No payment activity yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-5 border-t border-gray-100">{{ $payments->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
