<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Asili Yetu Hub') }} - Customer Dashboard</title>

        
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Playfair+Display:ital,wght@0,600;0,900;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

       
        @vite(['resources/css/app.css', 'resources/js/app.js'])

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

            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                overflow-x: hidden;
                margin: 0;
            }
            .font-artistic { font-family: 'Cinzel Decorative', serif; }
            .font-heading { font-family: 'Playfair Display', serif; }
        </style>
    </head>
    <body class="min-h-full flex flex-col text-gray-900 antialiased selection:bg-amber-600 selection:text-white bg-wavy-pattern">

       
        <div class="min-h-[calc(100vh-80px)] flex flex-col flex-1">

           
            @include('layouts.navigation')

          
            <header class="relative w-screen left-1/2 -translate-x-1/2 bg-[#3D2314] text-amber-50 shadow-md border-b border-amber-800/35 px-4 sm:px-6 lg:px-8 py-6">
                <div class="max-w-[1500px] mx-auto w-full flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h2 class="font-heading font-bold text-2xl text-amber-100">Customer Dashboard</h2>
                        <p class="text-sm text-amber-200/80">Karibu {{ auth()->user()->name }} — hapa utaona oda mpya, historia na taarifa za delivery.</p>
                    </div>
                    <a href="{{ route('cart.index') }}" class="inline-flex items-center justify-center rounded-xl bg-amber-200 px-4 py-2.5 text-sm font-bold text-[#3D2314] hover:bg-amber-300 transition shrink-0">← Rudi Kikapuni</a>
                </div>
            </header>

            
            <main class="flex-1 w-full">
                <div class="w-screen relative left-1/2 -translate-x-1/2 px-3 sm:px-6 lg:px-8 xl:px-10 py-6 sm:py-8">
                    <div class="max-w-[1500px] mx-auto space-y-8">

                        {{-- SUCCESS ALERT --}}
                        @if(session('success'))
                            <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-800 shadow-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- ERROR ALERT --}}
                        @if(session('error'))
                            <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-800 shadow-sm">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- STATS SECTION --}}
                        <section class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="rounded-2xl bg-white border border-amber-900/10 shadow-sm p-5">
                                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Oda Zote</p>
                                <p class="text-3xl font-heading font-black text-[#3D2314] mt-2">{{ $orders->count() }}</p>
                            </div>
                            <div class="rounded-2xl bg-white border border-amber-900/10 shadow-sm p-5">
                                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Oda Mpya</p>
                                <p class="text-3xl font-heading font-black text-amber-800 mt-2">{{ $newOrders->count() }}</p>
                            </div>
                            <div class="rounded-2xl bg-white border border-amber-900/10 shadow-sm p-5">
                                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Arifa</p>
                                <p class="text-3xl font-heading font-black text-green-700 mt-2">{{ $notifications->count() }}</p>
                            </div>
                        </section>

                        {{-- NOTIFICATIONS SECTION --}}
                        <section class="rounded-3xl bg-white/95 border border-amber-900/10 shadow-sm overflow-hidden">
                            <div class="p-6 border-b border-amber-900/10">
                                <h3 class="font-heading font-bold text-xl text-[#3D2314]">🔔 Notifications / Arifa</h3>
                                <p class="text-sm text-gray-500 mt-1">Status ya payment na shipment itaonekana hapa.</p>
                            </div>
                            <div class="divide-y divide-gray-100">
                                @forelse($notifications as $notification)
                                    <div class="p-5 flex flex-col sm:flex-row sm:items-center gap-4">
                                        <div class="w-11 h-11 rounded-full bg-amber-100 text-amber-900 flex items-center justify-center font-bold shrink-0">!</div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-bold text-gray-900">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                            <p class="text-sm text-gray-600 mt-1">{{ $notification->data['message'] ?? '' }}</p>
                                            <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at?->diffForHumans() }}</p>
                                        </div>
                                        @if(!empty($notification->data['order_id']))
                                            <a href="{{ route('orders.show', $notification->data['order_id']) }}" class="text-sm font-bold text-amber-800 hover:underline shrink-0">View Order</a>
                                        @endif
                                    </div>
                                @empty
                                    <div class="p-8 text-center text-sm text-gray-500">Hakuna arifa mpya kwa sasa.</div>
                                @endforelse
                            </div>
                        </section>

                        {{-- NEW ORDERS SECTION --}}
                        <section>
                            <div class="flex items-end justify-between mb-4">
                                <div>
                                    <h3 class="font-heading font-bold text-2xl text-[#3D2314]">Historia za Oda zako</h3>
                                    <p class="text-sm text-gray-500">Oda za siku 14 zilizopita.</p>
                                </div>
                            </div>

                            @if($newOrders->isEmpty())
                                <div class="rounded-3xl bg-white border border-dashed border-amber-300 p-10 text-center text-gray-500 shadow-sm">Hakuna oda mpya kwa sasa.</div>
                            @else
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                                    @foreach($newOrders as $order)
                                        @include('customer.partials.order-card', ['order' => $order])
                                    @endforeach
                                </div>
                            @endif
                        </section>

                    </div>
                </div>
            </main>

        </div>


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

        
        <div class="space-y-4">
            <div class="flex items-center space-x-3">
               
                <img src="{{ asset('assets/images/logo.jpeg') }}" 
                     alt="Asili Yetu Hub Logo" 
                     class="h-14 sm:h-16 w-auto object-contain drop-shadow-md rounded">
                
               
                <span class="text-2xl sm:text-3xl font-extrabold tracking-tight text-amber-200">
                    AsiliYetuHub
                </span>
            </div>

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

        <!-- Quick Links -->
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
    </body>
</html>
