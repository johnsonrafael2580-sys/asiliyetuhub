<x-app-layout>
    <div class="min-h-screen bg-[#FAF7F2] text-[#2E1B12] flex flex-col justify-between" style="background-image: url('data:image/svg+xml,%3Csvg width=%27100%27 height=%27100%27 viewBox=%270 0 100 100%27 xmlns=%27http://www.w3.org/2000/svg%27%3E%3Cpath d=%27M0 20 Q 25 5, 50 20 T 100 20 M0 50 Q 25 35, 50 50 T 100 50 M0 80 Q 25 65, 50 80 T 100 80%27 fill=%27none%27 stroke=%27%23854d0e%27 stroke-width=%271%27 stroke-opacity=%270.08%27/%3E%3Cpath d=%27M20 0 Q 5 25, 20 50 T 20 100 M50 0 Q 35 25, 50 50 T 50 100 M80 0 Q 65 25, 80 50 T 80 100%27 fill=%27none%27 stroke=%27%23854d0e%27 stroke-width=%271%27 stroke-opacity=%270.06%27/%3E%3C/svg%3E'); background-size: 120px 120px;">
        
        <div class="w-full flex-grow px-3 sm:px-6 lg:px-8 xl:px-10 py-6">
            <div class="max-w-[1500px] mx-auto space-y-6">
                
                
                <header class="relative w-full bg-[#F4EDE5] text-[#2E1B12] shadow-sm border border-[#D8C8B5] rounded-2xl px-4 sm:px-6 py-5">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.24em] text-[#7A685B]">Secure Checkout</p>
                            <h2 class="mt-1 font-heading font-black text-2xl text-[#2E1B12] tracking-wide">Order #{{ $order->id }}</h2>
                        </div>

                        <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center justify-center rounded-xl border border-[#D4B172] bg-transparent px-3 py-2 text-[11px] font-bold uppercase tracking-wide text-[#3D2314] transition hover:bg-[#F7EEDC]">
                            Order Details
                        </a>
                    </div>
                </header>

               
                @if(session('success'))
                    <div id="success-alert" class="flex items-center justify-between p-4 text-sm text-[#3D2314] bg-[#F6E7C9] border border-[#D4B172] rounded-2xl shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span class="font-bold">{{ session('success') }}</span>
                        </div>
                        <button onclick="document.getElementById('success-alert').remove()" class="text-[#3D2314] font-bold px-2 py-1">✕</button>
                    </div>
                @endif
                @if(session('error'))
                    <div id="error-alert" class="flex items-center justify-between p-4 text-sm text-[#3D2314] bg-[#F8E9D2] border border-[#D4B172] rounded-2xl shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span class="font-bold">{{ session('error') }}</span>
                        </div>
                        <button onclick="document.getElementById('error-alert').remove()" class="text-amber-900 font-bold px-2 py-1">✕</button>
                    </div>
                @endif

               
                <div class="grid gap-6 xl:grid-cols-[1.6fr_0.9fr]">
                    
                   
                    <main class="space-y-5">
                        <div class="p-5 sm:p-6 bg-white shadow-sm border border-amber-900/10 rounded-2xl space-y-4">
                            <div class="rounded-2xl border border-[#D9C5A1] bg-[#F7EFD9] p-4 sm:p-5">
                                <p class="text-[10px] font-black uppercase tracking-[0.22em] text-[#7F684E]">Amount Due</p>
                                <p class="mt-2 text-3xl font-black text-[#3D2314] sm:text-4xl">TZS {{ number_format($order->total_amount, 2) }}</p>
                                <p class="mt-2 text-sm text-gray-600">Payment request will be sent to <strong class="text-[#3D2314]">{{ $order->customer_phone }}</strong>.</p>
                            </div>
                        </div>

                       
                        <div class="grid gap-3 sm:grid-cols-3">
                            <div class="p-4 bg-white rounded-2xl border border-amber-900/10 shadow-sm">
                                <span class="text-[10px] font-black uppercase tracking-[0.22em] text-[#3D2314]">01</span>
                                <p class="mt-2 text-sm text-gray-600">Click <strong>Pay with Pesapal</strong></p>
                            </div>
                            <div class="p-4 bg-white rounded-2xl border border-amber-900/10 shadow-sm">
                                <span class="text-[10px] font-black uppercase tracking-[0.22em] text-[#3D2314]">02</span>
                                <p class="mt-2 text-sm text-gray-600">Complete payment on the Pesapal secure page.</p>
                            </div>
                            <div class="p-4 bg-white rounded-2xl border border-amber-900/10 shadow-sm">
                                <span class="text-[10px] font-black uppercase tracking-[0.22em] text-[#3D2314]">03</span>
                                <p class="mt-2 text-sm text-gray-600">Your order updates automatically</p>
                            </div>
                        </div>

                       
                        <div id="paymentStatus" class="p-4 bg-white rounded-2xl border border-amber-900/10 shadow-sm">
                            <div>
                                <h4 id="statusTitle" class="text-sm font-bold text-[#3D2314]">Ready for checkout</h4>
                                <p id="statusText" class="text-xs text-gray-500 mt-0.5">Click the button below to proceed to Pesapal</p>
                            </div>
                        </div>

                        
                        @if($order->payment_status !== 'paid')
                            <form method="POST" action="{{ route('payment.initiate') }}" class="max-w-[280px]">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <button type="submit" class="w-full rounded-xl bg-[#F0D8A8] px-4 py-3 text-xs font-black uppercase tracking-wide text-[#3D2314] shadow-sm border border-[#D4B172] transition hover:bg-[#E8C98F]">
                                    Pay with Pesapal
                                </button>
                            </form>
                        @else
                            <a href="{{ route('orders.show', $order) }}" class="block max-w-[280px] rounded-xl bg-[#E8C98F] px-4 py-3 text-center text-xs font-black uppercase tracking-wide text-[#3D2314] border border-[#D4B172] transition hover:bg-[#DDBB74]">
                                Payment Received — View Order
                            </a>
                        @endif
                    </main>

                   
                    <aside class="space-y-5">
                        <div class="p-5 bg-white text-[#2E1B12] rounded-2xl border border-[#D8C8B5] shadow-sm">
                            <p class="text-[10px] font-black uppercase tracking-[0.22em] text-[#7A685B]">Order Summary</p>

                            <div class="mt-4 space-y-3 max-h-64 overflow-y-auto pr-1">
                                @foreach($order->items as $item)
                                    <div class="flex items-start justify-between gap-4 border-b border-[#E9DFD4] pb-2 text-sm">
                                        <span class="text-[#3D2314]">{{ $item->product_title }} × {{ $item->quantity }}</span>
                                        <strong class="shrink-0 text-[#2E1B12]">TZS {{ number_format($item->subtotal, 2) }}</strong>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4 flex items-center justify-between border-t border-[#E9DFD4] pt-3 text-base font-black">
                                <span>Total</span>
                                <span>TZS {{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>

                        <div class="p-5 bg-white rounded-2xl border border-amber-900/10 shadow-sm">
                            <p class="text-[10px] font-black uppercase tracking-[0.22em] text-gray-400">What Happens Next</p>
                            <ul class="mt-3 space-y-2 text-sm text-gray-600">
                                <li class="flex gap-2"><span class="text-emerald-600">✓</span><span>Payment is verified by the provider</span></li>
                                <li class="flex gap-2"><span class="text-emerald-600">✓</span><span>Artisan receives the paid order automatically</span></li>
                                <li class="flex gap-2"><span class="text-emerald-600">✓</span><span>Email/WhatsApp updates are sent when configured</span></li>
                                <li class="flex gap-2"><span class="text-emerald-600">✓</span><span>Shipment progress appears in your dashboard</span></li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </div>

       
        <footer class="bg-[#2C180E] text-amber-100/80 border-t border-amber-900/60 mt-12 pt-10 pb-6 text-xs sm:text-sm font-medium px-3 sm:px-5 lg:px-8 relative overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center opacity-10 mix-blend-overlay pointer-events-none"
                 style="background-image:url('https://images.unsplash.com/photo-1590076215667-875d4ef2d7ee?auto=format&fit=crop&w=1200&q=80');">
            </div>

            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 relative z-10 text-left">
               
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('assets/images/logo.jpeg') }}" 
                             alt="Asili Yetu Hub Logo" 
                             class="h-14 sm:h-16 w-auto object-contain drop-shadow-md rounded">
                        <span class="text-2xl sm:text-3xl font-extrabold tracking-tight text-amber-200">
                            AsiliYetuHub
                        </span>
                    </div>

                    <p class="text-xs text-amber-200/70 leading-relaxed">
                        Connecting Tanzanian rural artisans, traditional performance groups, and cultural sites directly with global buyers and tourists.
                    </p>
                </div>

                
                <div class="space-y-2">
                    <h3 class="text-amber-300 font-bold text-sm tracking-wide border-b border-amber-800/50 pb-2 uppercase">Quick Links</h3>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="{{ url('/') }}" class="hover:text-amber-400 transition">Home</a></li>
                        <li><a href="#about-section" class="hover:text-amber-400 transition">About Us</a></li>
                        <li><a href="#marketplace-section" class="hover:text-amber-400 transition">Browse Crafts</a></li>
                    </ul>
                </div>

               
                <div class="space-y-2">
                    <h3 class="text-amber-300 font-bold text-sm tracking-wide border-b border-amber-800/50 pb-2 uppercase">Support & Policy</h3>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="{{ route('shipping') }}" class="hover:text-amber-400 transition">Shipping & Delivery</a></li>
                        <li><a href="{{ route('authenticity') }}" class="hover:text-amber-400 transition">Authenticity Guarantee</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-amber-400 transition">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-amber-400 transition">Terms of Service</a></li>
                    </ul>
                </div>

               
                <div class="space-y-2">
                    <h3 class="text-amber-300 font-bold text-sm tracking-wide border-b border-amber-800/50 pb-2 uppercase">Contact Us</h3>
                    <div class="space-y-1.5 text-xs text-amber-200/70">
                        <p class="flex items-center space-x-2">
                            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z" fill="#EA4335"/>
                                <path d="M12 2c3.86 0 7 3.14 7 7 0 4.41-5.38 9.79-6.52 10.86a1.08 1.08 0 0 1-1.48 0C10.38 18.79 5 13.41 5 9c0-3.86 3.14-7 7-7zm0 2.8A4.2 4.2 0 0 0 7.8 9a4.2 4.2 0 0 0 8.4 0A4.2 4.2 0 0 0 12 4.8z" fill="#34A853" opacity="0.18"/>
                                <path d="M12 2c3.86 0 7 3.14 7 7 0 4.41-5.38 9.79-6.52 10.86a1.08 1.08 0 0 1-1.48 0C10.38 18.79 5 13.41 5 9c0-3.86 3.14-7 7-7zm0 2.8A4.2 4.2 0 0 0 7.8 9a4.2 4.2 0 0 0 8.4 0A4.2 4.2 0 0 0 12 4.8z" fill="#4285F4" opacity="0.12"/>
                            </svg>
                            <a href="https://maps.google.com/?q=Dar+es+Salaam,+Tanzania"
                               target="_blank"
                               class="hover:text-amber-400 hover:underline transition">
                                Dar es Salaam / Arusha, Tanzania
                            </a>
                        </p>
                        <p class="flex items-center space-x-2"><span>📞</span><span>+255 700 000 000</span></p>
                        <p class="flex items-center space-x-2"><span>✉️</span><span>info@asiliyetuhub.co.tz</span></p>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto border-t border-amber-900/60 pt-5 flex flex-col sm:flex-row justify-between items-center text-xs text-amber-200/60 gap-3 relative z-10">
                <p>&copy; {{ date('Y') }} Asili Yetu Hub. Empowering Tanzanian Artisans & Cultural Tourism</p>
            </div>
        </footer>
    </div>

    @push('scripts')
    <script>
        (() => {
            const url = @json(route('orders.payment.status', $order));
            const title = document.getElementById('statusTitle');
            const text = document.getElementById('statusText');

            const poll = async () => {
                try {
                    const r = await fetch(url, { headers: { 'Accept': 'application/json' } });
                    const data = await r.json();

                    if (data.payment_status === 'paid') {
                        title.textContent = 'Payment received automatically';
                        text.textContent = 'Your order is now processing. Redirecting...';
                        setTimeout(() => window.location.href = @json(route('orders.show', $order)), 900);
                        return;
                    }

                    if (['failed', 'rejected'].includes(data.payment_status)) {
                        title.textContent = 'Payment needs another attempt';
                        text.textContent = 'The provider did not complete this payment. You can try again.';
                        return;
                    }
                } catch (e) {
                    
                }

                setTimeout(poll, 4000);
            };

            @if($order->payment_status !== 'paid')
                poll();
            @endif
        })();
    </script>
    @endpush
</x-app-layout>
