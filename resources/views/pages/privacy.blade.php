<x-app-layout>
    @push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        .font-heading { font-family: 'Playfair Display', serif; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    @endpush

    <x-slot name="header">
        <div class="bg-[#3D2314] -m-6 px-6 py-6 border-b border-amber-800/30 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-heading font-black text-2xl sm:text-3xl text-amber-100 tracking-wide" data-en="Privacy Policy" data-sw="Sera ya Faragha">
                    Privacy Policy
                </h2>
                <p class="text-xs sm:text-sm text-amber-200/80 mt-1 font-medium" data-en="How we collect, use, and protect your personal data" data-sw="Jinsi tunavyokusanya, kutumia na kulinda taarifa zakos za binafsi">
                    How we collect, use, and protect your personal data
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 sm:py-12 bg-wavy-pattern min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 sm:p-10 bg-white shadow-sm border border-amber-900/10 rounded-2xl space-y-6 text-gray-700">
                <header class="border-b border-amber-900/10 pb-4 mb-6">
                    <h1 class="text-2xl font-heading font-bold text-[#3D2314]" data-en="Privacy Policy" data-sw="Sera ya Faragha">
                        Privacy Policy
                    </h1>
                </header>

                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-[#3D2314]" data-en="1. Information We Collect" data-sw="1. Taarifa Tunazokusanya">1. Information We Collect</h3>
                    <p data-en="We collect information such as your name, email address, phone number, and shipping address when you create an account or place an order." data-sw="Tunakusanya taarifa kama vile jina lako, barua pepe, namba ya simu na anwani ya usafirishaji unapofungua akaunti au kuweka oda.">
                        We collect information such as your name, email address, phone number, and shipping address when you create an account or place an order.
                    </p>

                    <h3 class="text-lg font-bold text-[#3D2314]" data-en="2. Data Protection" data-sw="2. Ulinzi wa Data">2. Data Protection</h3>
                    <p data-en="Your personal information is stored securely and is never shared or sold to third parties without your explicit consent." data-sw="Taarifa zakos za binafsi zinalindwa kwa usalama na hazitashirikishwa wala kuuzwa kwa mtu yeyote bila idhini yako.">
                        Your personal information is stored securely and is never shared or sold to third parties without your explicit consent.
                    </p>
                </div>
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

        <!-- Brand -->
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

        <!-- Support & Policy -->
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

        <!-- Contact -->
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
