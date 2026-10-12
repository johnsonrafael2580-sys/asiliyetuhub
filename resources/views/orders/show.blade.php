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
                <h2 class="font-heading font-black text-2xl text-amber-100 tracking-wide">
                    Order #{{ $order->id }}
                </h2>
                <p class="text-xs sm:text-sm text-amber-200/80 mt-1 font-medium" data-en="Order details, payment, and delivery tracking." data-sw="Maelezo ya oda, payment na delivery tracking.">
                    Maelezo ya oda, payment na delivery tracking.
                </p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('customer.dashboard') }}" class="px-4 py-2 text-xs font-bold text-amber-200 bg-amber-900/60 border border-amber-800/50 rounded-xl hover:bg-amber-900 transition flex items-center space-x-1 shadow-sm">
                    <span>←</span>
                    <span data-en="Back to Dashboard" data-sw="Rudi Dashibodi">Back to Dashboard</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-wavy-pattern min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="rounded-2xl border border-emerald-300 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-900 shadow-sm flex items-center space-x-2">
                    <span>✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="rounded-2xl border border-red-300 bg-red-50 px-5 py-4 text-sm font-semibold text-red-900 shadow-sm flex items-center space-x-2">
                    <span>⚠</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @php
                $statusSteps = [
                    'pending' => 'Oda imetumwa',
                    'processing' => 'Inaandaliwa',
                    'shipped' => 'Imesafirishwa',
                    'delivered' => 'Imefika',
                ];
                $statusOrder = ['pending', 'processing', 'shipped', 'delivered'];
                $currentIndex = array_search($order->status, $statusOrder, true);
                if ($currentIndex === false) $currentIndex = 0;
            @endphp

           
            <div class="rounded-2xl bg-white border border-amber-900/10 shadow-sm p-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
                    <div>
                        <p class="text-xs uppercase tracking-wider font-bold text-gray-500" data-en="Order Status" data-sw="Hali ya Oda">Order Status</p>
                        <h3 class="font-heading font-black text-2xl text-[#3D2314] mt-1">{{ str_replace('_', ' ', ucfirst($order->status)) }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Payment: <strong>{{ str_replace('_', ' ', $order->payment_status) }}</strong></p>
                    </div>

                    @if($order->payment_status !== 'paid')
                        <a href="{{ route('orders.payment', $order) }}" class="rounded-xl bg-amber-700 hover:bg-amber-800 text-white font-bold px-5 py-3 text-center text-xs uppercase tracking-wider shadow-sm transition">
                            Lipia Oda
                        </a>
                    @elseif($order->escrow_status === 'released_to_artisan')
                        <span class="rounded-xl bg-emerald-100 text-emerald-900 border border-emerald-300 font-bold px-5 py-3 text-xs">
                            ✓ Malipo yameachiliwa
                        </span>
                    @endif
                </div>

                <div class="mt-8 grid grid-cols-4 gap-2">
                    @foreach($statusSteps as $key => $label)
                        @php $index = array_search($key, $statusOrder, true); @endphp
                        <div class="text-center">
                            <div class="mx-auto w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all {{ $index <= $currentIndex ? 'bg-[#3D2314] text-amber-200 shadow-sm' : 'bg-gray-100 text-gray-400' }}">
                                {{ $index + 1 }}
                            </div>
                            <p class="text-[11px] sm:text-xs font-bold mt-2 {{ $index <= $currentIndex ? 'text-[#3D2314]' : 'text-gray-400' }}">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            
            <div class="rounded-2xl bg-white border border-amber-900/10 shadow-sm p-6">
                <div class="flex items-center justify-between mb-5 border-b border-amber-900/10 pb-4">
                    <div>
                        <h3 class="font-heading font-bold text-xl text-[#3D2314]" data-en="Order Items & Shipment Status" data-sw="Vitu vya Oda & Hali ya Usafirishaji">
                            Vitu vya Oda & Shipment Status
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-500 mt-0.5" data-en="Each item status is updated directly by the artisan." data-sw="Kila bidhaa ina status yake kutoka kwa artisan.">
                            Kila bidhaa ina status yake kutoka kwa artisan.
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($order->items as $item)
                        @php $itemShipping = $item->shipping_fee_per_item * $item->quantity; @endphp
                        <div class="rounded-2xl border border-amber-900/10 bg-amber-50/40 p-5">
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                <div>
                                    <h4 class="font-bold text-[#3D2314] text-lg">{{ $item->product_title }}</h4>
                                    <p class="text-xs text-gray-600 mt-1">Qty: {{ $item->quantity }} · Artisan: <strong class="text-gray-800">{{ $item->artisan?->name ?? '—' }}</strong></p>
                                </div>
                                <span class="rounded-full bg-white border border-amber-300 px-3 py-1 text-xs font-bold text-amber-900 self-start">
                                    {{ str_replace('_', ' ', ucfirst($item->fulfillment_status ?? 'pending')) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-5 text-sm pt-4 border-t border-amber-900/10">
                                <div>
                                    <p class="text-gray-500 text-xs">Base Price</p>
                                    <p class="font-bold text-gray-900">TZS {{ number_format($item->base_product_price * $item->quantity, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs">Shipping Fee</p>
                                    @if($itemShipping > 0)
                                        <p class="font-bold text-gray-900">TZS {{ number_format($itemShipping, 2) }}</p>
                                    @else
                                        <p class="font-bold text-amber-900 text-xs mt-0.5" data-en="Agreed with Artisan" data-sw="Makubaliano na Fundi">
                                            Makubaliano na Fundi
                                        </p>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs">Subtotal</p>
                                    <p class="font-bold text-[#3D2314]">TZS {{ number_format($item->subtotal, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs">Payment</p>
                                    <p class="font-bold text-gray-900">{{ ucfirst($item->payment_status) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

           
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                
                <div class="rounded-2xl bg-white border border-amber-900/10 shadow-sm p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="font-heading font-bold text-xl text-[#3D2314] mb-5 border-b border-amber-900/10 pb-3" data-en="Financial Summary" data-sw="Muhtasari wa Malipo">
                            Financial Summary
                        </h3>
                        <div class="space-y-3.5 text-sm">
                            <div class="flex justify-between items-center text-gray-700">
                                <span>Product total</span>
                                <strong class="text-gray-900">TZS {{ number_format($pricingBreakdown['base_product_total'], 2) }}</strong>
                            </div>

                            <div class="flex justify-between items-center text-gray-700">
                                <span>Shipping & logistics</span>
                                @if($pricingBreakdown['shipping_total'] > 0)
                                    <strong class="text-gray-900">TZS {{ number_format($pricingBreakdown['shipping_total'], 2) }}</strong>
                                @else
                                    <span class="text-xs font-bold text-amber-900 bg-amber-100 px-2.5 py-1 rounded-full border border-amber-300" data-en="Direct Agreement" data-sw="Makubaliano na Fundi">
                                        Makubaliano na Fundi
                                    </span>
                                @endif
                            </div>

                            <div class="border-t border-amber-900/10 pt-3 flex justify-between items-center text-base">
                                <span class="font-bold text-[#3D2314]">Total charged</span>
                                <strong class="text-amber-900 font-black">TZS {{ number_format($pricingBreakdown['total_charged'], 2) }}</strong>
                            </div>

                            <div class="flex justify-between items-center text-gray-500 text-xs pt-1">
                                <span>Platform commission (10%)</span>
                                <span>TZS {{ number_format($pricingBreakdown['platform_commission'], 2) }}</span>
                            </div>

                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-500">Artisan net earnings</span>
                                <strong class="text-emerald-700 font-bold">TZS {{ number_format($pricingBreakdown['artisan_earnings'], 2) }}</strong>
                            </div>
                        </div>
                    </div>

                   
                    @if(($pricingBreakdown['shipping_total'] ?? 0) == 0)
                        <div class="mt-6 p-4 bg-amber-50/80 border border-amber-200 rounded-2xl flex items-start gap-3">
                            <span class="text-xl shrink-0">🚚</span>
                            <div class="text-xs text-amber-900">
                                <strong class="font-bold block text-sm text-[#3D2314]" data-en="Logistics & Delivery Notice" data-sw="Taarifa ya Usafirishaji">
                                    Taarifa ya Usafirishaji
                                </strong>
                                <p class="mt-1 text-amber-900/80 leading-relaxed" data-en="Shipping costs for this order will be negotiated and settled directly between you and the artisan depending on your location." data-sw="Gharama na taratibu za usafirishaji wa mzigo huu zitafanyika kwa makubaliano ya moja kwa moja kati yako na fundi (artisan) kulingana na eneo uliopo.">
                                    Gharama na taratibu za usafirishaji wa mzigo huu zitafanyika kwa makubaliano ya moja kwa moja kati yako na fundi (artisan) kulingana na eneo uliopo.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                
                <div class="rounded-2xl bg-white border border-amber-900/10 shadow-sm p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="font-heading font-bold text-xl text-[#3D2314] mb-5 border-b border-amber-900/10 pb-3">Delivery & automatic settlement</h3>
                        @if($order->escrow_status === 'released_to_artisan')
                            <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-sm font-semibold text-emerald-900">✓ Delivery completed and payment settlement has been released automatically.</div>
                        @elseif($order->payment_status !== 'paid')
                            <div class="rounded-2xl bg-amber-50 border border-amber-200 p-4 text-sm text-amber-900">Payment is not complete yet. Use the automatic payment page; no admin confirmation is required.</div>
                        @else
                            <div class="rounded-2xl bg-blue-50 border border-blue-200 p-4 text-sm text-blue-900">📦 Shipment is being handled. When the fulfillment status becomes delivered, settlement is processed automatically and your dashboard will update.</div>
                        @endif
                    </div>
                </div>

           
            <div class="flex flex-col sm:flex-row gap-3 justify-end pt-2">
                @if(in_array($order->payment_status, ['failed', 'pending'], true) && $order->status !== 'cancelled')
                    <a href="{{ route('orders.payment', $order) }}" class="rounded-xl bg-amber-800 hover:bg-amber-900 text-white font-bold px-6 py-3 text-center text-xs uppercase tracking-wider transition shadow-sm">
                        Payment Page
                    </a>
                @endif
                @if(!in_array($order->status, ['delivered', 'cancelled'], true))
                    <form method="POST" action="{{ route('orders.cancel', $order) }}" onsubmit="return confirm('Una uhakika unataka kughairi oda hii?');">
                        @csrf
                        <button type="submit" class="rounded-xl border border-red-300 bg-white hover:bg-red-50 text-red-700 font-bold px-6 py-3 text-xs uppercase tracking-wider transition shadow-sm w-full sm:w-auto">
                            Ghairi Oda
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
     
<footer class="bg-[#2C180E] text-amber-100/80 border-t border-amber-900/60 mt-10 pt-10 pb-6 text-xs sm:text-sm font-medium px-3 sm:px-5 lg:px-8 relative overflow-hidden">

    <div class="absolute inset-0 bg-cover bg-center opacity-10 mix-blend-overlay pointer-events-none"
         style="background-image:url('https://images.unsplash.com/photo-1590076215667-875d4ef2d7ee?auto=format&fit=crop&w=1200&q=80');">
    </div>

    <div class="absolute inset-0 opacity-5 pointer-events-none bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-600 via-transparent to-transparent">
        <svg class="w-full h-full text-amber-500 fill-current opacity-20"
             xmlns="http://www.w3.org/2000/svg"
             width="100%"
             height="100%">
            <defs>
                <pattern id="african-pattern"
                         width="60"
                         height="60"
                         patternUnits="userSpaceOnUse">
                    <path d="M30 0 L60 30 L30 60 L0 30 Z M30 10 L50 30 L30 50 L10 30 Z"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="1"/>
                    <circle cx="30"
                            cy="30"
                            r="3"
                            fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100%"
                  height="100%"
                  fill="url(#african-pattern)"/>
        </svg>
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 relative z-10 text-left">

        
        <div class="space-y-3">
            <span class="text-xl font-artistic text-amber-300 tracking-wider block">
                Asili Yetu Hub
            </span>

            <p class="text-xs text-amber-200/70 leading-relaxed"
               data-en="Connecting Tanzanian rural artisans, traditional performance groups, and cultural sites directly with global buyers and tourists."
               data-sw="Kuwezesha mafundi wa mikono wa vijijini, vikundi vya ngoma za asili na maeneo ya utalii wa kitamaduni kuunganisha moja kwa moja na wanunuzi na watalii.">
                Connecting Tanzanian rural artisans, traditional performance groups,
                and cultural sites directly with global buyers and tourists.
            </p>

            <div class="flex items-center space-x-3 pt-1">
                <a href="https://www.facebook.com/share/19Y5JdJEf6/"
                   class="w-8 h-8 rounded-full bg-amber-900/60 border border-amber-700/40 flex items-center justify-center text-amber-200 hover:bg-amber-600 hover:text-white transition">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>

                <a href="https://www.instagram.com/johnstone.junior.450229?stkn=cXZnaG9pOTFlazBq"
                   class="w-8 h-8 rounded-full bg-amber-900/60 border border-amber-700/40 flex items-center justify-center text-amber-200 hover:bg-amber-600 hover:text-white transition">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>

                <a href="https://vm.tiktok.com/ZS9ALDKRmSrC8-PQnbu/"
                   class="w-8 h-8 rounded-full bg-amber-900/60 border border-amber-700/40 flex items-center justify-center text-amber-200 hover:bg-amber-600 hover:text-white transition"
                   aria-label="TikTok">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.82.56-1.33 1.52-1.32 2.52-.02.97.47 1.93 1.25 2.5 1.05.78 2.5.83 3.59.13.88-.55 1.42-1.55 1.41-2.59.02-5.46.01-10.93.01-16.39z"/>
                    </svg>
                </a>
            </div>
        </div>

        
        <div class="space-y-2">
            <h3 class="text-amber-300 font-bold text-sm tracking-wide border-b border-amber-800/50 pb-2 uppercase"
                data-en="Quick Links"
                data-sw="Viungo vya Haraka">
                Quick Links
            </h3>

            <ul class="space-y-1.5 text-xs">
                <li>
                    <a href="{{ url('/') }}"
                       class="hover:text-amber-400 transition"
                       data-en="Home"
                       data-sw="Nyumbani">
                        Home
                    </a>
                </li>
                <li>
                    <a href="#about-section"
                       class="hover:text-amber-400 transition"
                       data-en="About Us"
                       data-sw="Kuhusu Sisi">
                        About Us
                    </a>
                </li>
                <li>
                    <a href="#marketplace-section"
                       class="hover:text-amber-400 transition"
                       data-en="Browse Crafts"
                       data-sw="Vinjari Sanaa na Bidhaa">
                        Browse Crafts
                    </a>
                </li>
            </ul>
        </div>

        
        <div class="space-y-2">
            <h3 class="text-amber-300 font-bold text-sm tracking-wide border-b border-amber-800/50 pb-2 uppercase"
                data-en="Support & Policy"
                data-sw="Msaada na Sera">
                Support & Policy
            </h3>

            <ul class="space-y-1.5 text-xs">
                <li>
                    <a href="{{ route('shipping') }}"
                       class="hover:text-amber-400 transition"
                       data-en="Shipping & Delivery"
                       data-sw="Usafirishaji na Ufikishaji">
                        Shipping & Delivery
                    </a>
                </li>
                <li>
                    <a href="{{ route('authenticity') }}"
                       class="hover:text-amber-400 transition"
                       data-en="Authenticity Guarantee"
                       data-sw="Uhakika wa Ubora wa Asili">
                        Authenticity Guarantee
                    </a>
                </li>
                <li>
                    <a href="{{ route('privacy') }}"
                       class="hover:text-amber-400 transition"
                       data-en="Privacy Policy"
                       data-sw="Sera ya Faragha">
                        Privacy Policy
                    </a>
                </li>
                <li>
                    <a href="{{ route('terms') }}"
                       class="hover:text-amber-400 transition"
                       data-en="Terms of Service"
                       data-sw="Vigezo na Masharti">
                        Terms of Service
                    </a>
                </li>
            </ul>
        </div>

       
        <div class="space-y-2">
            <h3 class="text-amber-300 font-bold text-sm tracking-wide border-b border-amber-800/50 pb-2 uppercase"
                data-en="Contact Us"
                data-sw="Wasiliana Nasi">
                Contact Us
            </h3>

            <div class="space-y-1.5 text-xs text-amber-200/70">
                <p class="flex items-center space-x-2">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    <a href="https://maps.google.com/?q=Dar+es+Salaam,+Tanzania"
                       target="_blank"
                       class="hover:text-amber-400 hover:underline transition">
                        Dar es Salaam / Arusha, Tanzania
                    </a>
                </p>

                <p class="flex items-center space-x-2">
                    <span>📞</span>
                    <span>+255 700 000 000</span>
                </p>

                <p class="flex items-center space-x-2">
                    <span>✉️</span>
                    <span>info@asiliyetuhub.co.tz</span>
                </p>
            </div>
        </div>

    </div>

    <div class="max-w-7xl mx-auto border-t border-amber-900/60 pt-5 flex flex-col sm:flex-row justify-between items-center text-xs text-amber-200/60 gap-3 relative z-10">
        <p>
            &copy; {{ date('Y') }} Asili Yetu Hub.
            <span data-en="Empowering Tanzanian Artisans & Cultural Tourism."
                  data-sw="Kuwezesha Wasanii wa Kitanzania na Utalii wa Kitamaduni.">
                Empowering Tanzanian Artisans & Cultural Tourism.
            </span>
        </p>
    </div>

</footer>
