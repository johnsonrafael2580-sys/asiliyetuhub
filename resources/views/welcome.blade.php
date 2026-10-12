<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title data-en="Asili Yetu Hub - Direct Tanzanian Crafts & Culture"
           data-sw="Asili Yetu Hub - Sanaa na Utamaduni wa Kitanzania">
        Asili Yetu Hub - Direct Tanzanian Crafts & Culture
    </title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Playfair+Display:ital,wght@0,600;0,900;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <style>
        @keyframes movePattern {
            0% { background-position: 0 0; }
            100% { background-position: 120px 120px; }
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAF7F2;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 20 Q 25 5, 50 20 T 100 20 M0 50 Q 25 35, 50 50 T 100 50 M0 80 Q 25 65, 50 80 T 100 80' fill='none' stroke='%23854d0e' stroke-width='1' stroke-opacity='0.08'/%3E%3Cpath d='M20 0 Q 5 25, 20 50 T 20 100 M50 0 Q 35 25, 50 50 T 50 100 M80 0 Q 65 25, 80 50 T 80 100' fill='none' stroke='%23854d0e' stroke-width='1' stroke-opacity='0.06'/%3E%3C/svg%3E");
            background-size: 120px 120px;
            animation: movePattern 25s linear infinite;
        }

        .font-artistic {
            font-family: 'Cinzel Decorative', serif;
        }

        .font-heading {
            font-family: 'Playfair Display', serif;
        }

        @keyframes kenburns {
            0% { transform: scale(1); }
            50% { transform: scale(1.06); }
            100% { transform: scale(1); }
        }

        .hero-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 2s ease-in-out;
            animation: kenburns 12s infinite alternate;
            z-index: 0;
        }

        .hero-slide.active {
            opacity: 0.55;
        }

        @keyframes floatSlow1 {
            0%, 100% { transform: translateY(0) rotate(-3deg); }
            50% { transform: translateY(-8px) rotate(-1deg); }
        }

        @keyframes floatSlow2 {
            0%, 100% { transform: translateY(0) rotate(3deg); }
            50% { transform: translateY(-10px) rotate(5deg); }
        }

        @keyframes floatSlow3 {
            0%, 100% { transform: translateY(0) rotate(2deg); }
            50% { transform: translateY(-6px) rotate(0deg); }
        }

        @keyframes floatSlow4 {
            0%, 100% { transform: translateY(0) rotate(-2deg); }
            50% { transform: translateY(-9px) rotate(-4deg); }
        }

        .animate-float-1 {
            animation: floatSlow1 5s ease-in-out infinite;
        }

        .animate-float-2 {
            animation: floatSlow2 6s ease-in-out infinite;
        }

        .animate-float-3 {
            animation: floatSlow3 5.5s ease-in-out infinite;
        }

        .animate-float-4 {
            animation: floatSlow4 6.5s ease-in-out infinite;
        }

       
        #page-loader {
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        
        #page-loader::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(44, 24, 14, 0.24);
            -webkit-backdrop-filter: blur(6px);
            backdrop-filter: blur(6px);
            pointer-events: none;
        }

        
        #page-loader > div {
            position: relative;
            z-index: 1;
        }

        #page-loader.fade-out {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        @keyframes spinRing {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .spinner-ring {
            animation: spinRing 1.5s linear infinite;
        }
    </style>
</head>

<body class="text-gray-900 antialiased selection:bg-amber-600 selection:text-white">


<div id="page-loader">
    <div class="relative flex items-center justify-center">
       
        <div class="absolute w-28 h-28 rounded-full border-4 border-amber-600 border-t-transparent spinner-ring"></div>
       
        <div class="w-20 h-20 rounded-full bg-[#3D2314] flex items-center justify-center overflow-hidden shadow-xl border-2 border-amber-500/50 p-2">
            <img src="{{ asset('assets/images/logo.jpeg') }}" alt="Asili Yetu Hub Logo" class="w-full h-full object-cover rounded-full">
        </div>
    </div>
</div>

<header class="bg-[#3D2314] shadow-md sticky top-0 z-50 border-b border-amber-800/30">

    <div class="max-w-7xl mx-auto px-3 sm:px-5 lg:px-8 h-16 sm:h-20 flex justify-between items-center">

        <div class="flex items-center">
            <span class="text-lg sm:text-2xl font-artistic text-amber-300 tracking-wider">
                Asili Yetu Hub
            </span>
        </div>

        <div class="flex items-center mx-2 sm:mx-4">
            @include('components/language-toggle')
        </div>

       
        <div class="hidden md:flex items-center space-x-4">

            <nav class="flex items-center space-x-4 mr-2">
                <a href="{{ url('/') }}"
                   class="text-xs sm:text-sm font-bold text-amber-200 hover:text-white transition"
                   data-en="Home"
                   data-sw="Nyumbani">
                    Home
                </a>

                <a href="#about-section"
                   class="text-xs sm:text-sm font-bold text-amber-200 hover:text-white transition"
                   data-en="About"
                   data-sw="Kuhusu Sisi">
                    About
                </a>

                <a href="#marketplace-section"
                   class="text-xs sm:text-sm font-bold text-amber-200 hover:text-white transition"
                   data-en="Marketplace"
                   data-sw="Soko">
                    Marketplace
                </a>
            </nav>

            <a href="{{ route('cart.index') }}"
               class="relative text-amber-200 hover:text-white transition flex items-center space-x-1 py-1">

                <span class="text-base">🛒</span>

                @php
                    $cartCount = array_sum(
                        array_column(session()->get('cart', []), 'quantity')
                    );
                @endphp

                <span id="cartCountBadgeDesktop"
                      class="{{ $cartCount > 0 ? '' : 'hidden' }} bg-amber-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow">
                    {{ $cartCount }}
                </span>
            </a>

            @if (Route::has('login'))
                @auth

                    <a href="{{ url('/dashboard') }}"
                       class="px-4 py-2 text-sm font-bold text-amber-900 bg-amber-200 rounded-xl hover:bg-amber-300 shadow-sm transition"
                       data-en="Dashboard"
                       data-sw="Dashibodi">
                        Dashboard
                    </a>

                @else

                    <a href="{{ route('login') }}"
                       class="px-3 py-2 text-sm font-semibold text-amber-200 hover:text-white transition"
                       data-en="Log in"
                       data-sw="Ingia">
                        Log in
                    </a>

                    @if (Route::has('register'))

                        <a href="{{ route('register') }}"
                           class="px-3 py-1.5 text-xs font-bold text-white bg-amber-600 rounded-lg hover:bg-amber-700 shadow-sm transition"
                           data-en="Register"
                           data-sw="Jisajili">
                            Register
                        </a>

                    @endif
                @endauth
            @endif

        </div>

     
        <div class="flex md:hidden items-center space-x-2">

            <a href="{{ route('cart.index') }}"
               class="relative text-amber-200 hover:text-white transition flex items-center space-x-1 py-1">

                <span class="text-base">🛒</span>

                @php
                    $cartCount = array_sum(
                        array_column(session()->get('cart', []), 'quantity')
                    );
                @endphp

                <span id="cartCountBadgeMobile"
                      class="{{ $cartCount > 0 ? '' : 'hidden' }} bg-amber-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow">
                    {{ $cartCount }}
                </span>

            </a>

            <button id="mobile-menu-button"
                    type="button"
                    class="text-amber-200 hover:text-white focus:outline-none p-2 rounded-lg bg-amber-900/50 border border-amber-800/40"
                    aria-label="Toggle Menu">

                <svg class="w-6 h-6"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16">
                    </path>

                </svg>

            </button>

        </div>
    </div>

   
    <div id="mobile-menu"
         class="hidden md:hidden bg-[#2C180E] border-t border-amber-900/40 px-3 pt-2 pb-3 space-y-1 shadow-lg">

        <a href="{{ url('/') }}"
           class="block px-4 py-2 text-sm font-semibold text-amber-200 hover:bg-amber-900/40 rounded-xl transition"
           data-en="Home"
           data-sw="Nyumbani">
            Home
        </a>

        <a href="#about-section"
           class="block px-4 py-2 text-sm font-semibold text-amber-200 hover:bg-amber-900/40 rounded-xl transition"
           data-en="About"
           data-sw="Kuhusu Sisi">
            About
        </a>

        <a href="#marketplace-section"
           class="block px-4 py-2 text-sm font-semibold text-amber-200 hover:bg-amber-900/40 rounded-xl transition"
           data-en="Marketplace"
           data-sw="Soko">
            Marketplace
        </a>

        <hr class="border-amber-800/40 my-1">

        @if (Route::has('login'))
            @auth

                <a href="{{ url('/dashboard') }}"
                   class="block w-full text-center px-4 py-2.5 text-sm font-bold text-amber-900 bg-amber-200 rounded-xl shadow"
                   data-en="Dashboard"
                   data-sw="Dashibodi">
                    Dashboard
                </a>

            @else

                <a href="{{ route('login') }}"
                   class="block w-full text-center px-4 py-2.5 text-sm font-semibold text-amber-200 bg-amber-900/40 rounded-xl border border-amber-800/30 hover:bg-amber-900 transition"
                   data-en="Log in"
                   data-sw="Ingia">
                    Log in
                </a>

                @if (Route::has('register'))

                    <a href="{{ route('register') }}"
                       class="block w-full text-center px-4 py-2.5 text-sm font-bold text-white bg-amber-600 rounded-xl hover:bg-amber-700 shadow mt-1"
                       data-en="Register"
                       data-sw="Jisajili">
                        Register
                    </a>

                @endif
            @endauth
        @endif

    </div>
</header>


<section class="relative h-[45vh] sm:h-[50vh] flex items-center justify-center overflow-hidden bg-[#26150D] text-center">

    <div class="absolute inset-0 z-0 overflow-hidden">

        <div class="hero-slide active"
             style="background-image:url('https://custom-images.strikinglycdn.com/res/hrscywv4p/image/upload/c_limit,fl_lossy,h_9000,w_1200,f_auto,q_auto/996195/184247_605004.jpeg');">
        </div>

        <div class="hero-slide"
             style="background-image:url('https://custom-images.strikinglycdn.com/res/hrscywv4p/image/upload/c_limit,fl_lossy,h_9000,w_1200,f_auto,q_auto/996195/654846_252346.png');">
        </div>

    </div>

    <div class="relative z-20 w-full px-4 sm:px-6 lg:px-8 py-5 flex flex-col items-center">

        <div class="max-w-3xl">

            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-heading font-black tracking-tight mb-2 sm:mb-3 text-amber-50 leading-tight drop-shadow-lg"
                data-en="Connecting Rural Artisans Directly to Buyers"
                data-sw="Tunalenga Kuwaunganisha Mafundi Stadi wa Vijijini Moja kwa Moja na Watalii/Wanunuzi">

                Connecting Rural Artisans Directly to Buyers

            </h1>

            <p class="text-xs sm:text-sm lg:text-base text-amber-100/90 mb-4 font-medium leading-relaxed drop-shadow"
               data-en="Support traditional Tanzanian craftsmanship. Buy authentic wood carvings, handmade beadwork, pottery, and paintings directly from local artisans without middlemen."
               data-sw="Saidia ufundi wa kitamaduni wa Kitanzania. Nununua chongaji halisi ya mbao, ushanga wa mikono, vyungu, na michoro moja kwa moja kutoka kwa mafundi stadi wa ndani bila madalali.">

                Support traditional Tanzanian craftsmanship.
                Buy authentic wood carvings, handmade beadwork,
                pottery, and paintings directly from local artisans without middlemen.

            </p>

            <a href="#marketplace-section"
               class="inline-block px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow transition"
               data-en="↓ Explore Marketplace"
               data-sw="↓ Chunguza Soko">

                ↓ Explore Marketplace

            </a>

        </div>
    </div>
</section>


<div id="about-section"
     class="max-w-7xl mx-auto px-3 sm:px-5 lg:px-8 scroll-mt-24">

    <div class="relative w-full bg-[#FAF8F5] bg-[url('data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M0 20 Q 25 5, 50 20 T 100 20 M0 50 Q 25 35, 50 50 T 100 50 M0 80 Q 25 65, 50 80 T 100 80\' fill=\'none\' stroke=\'%23E8DFD8\' stroke-width=\'1.5\'/%3E%3Cpath d=\'M20 0 Q 5 25, 20 50 T 20 100 M50 0 Q 35 25, 50 50 T 50 100 M80 0 Q 65 25, 80 50 T 80 100\' fill=\'none\' stroke=\'%23E8DFD8\' stroke-width=\'1.5\'/%3E%3C/svg%3E')] bg-repeat p-5 sm:p-8 lg:p-10 rounded-3xl overflow-hidden shadow-inner my-5 border border-amber-900/10">

        <div class="w-full mx-auto flex flex-col md:flex-row items-center justify-between gap-7 lg:gap-10 relative z-10">

            <div class="flex-1 text-left space-y-3">

                <h2 class="text-2xl sm:text-4xl font-heading font-black text-[#3D2314]"
                    data-en="Our Culture & Native Heritage"
                    data-sw="Utamaduni Wetu na Urithi wa Asili">

                    Our Culture & Native Heritage

                </h2>

                <p class="text-xs sm:text-sm lg:text-base text-gray-700 leading-relaxed"
                   data-en="Welcome to discover and enjoy the authentic richness of our culture through Asili Yetu Hub! This platform is uniquely designed to solve key challenges by directly connecting local artisans, traditional performance groups, and rural cultural tourism sites with their buyers."
                   data-sw="Karibu utambue na ufurahie utajiri halisi wa utamaduni wetu kupitia Asili Yetu Hub! Mtandao huu umebuniwa mahususi kuleta suluhisho la kipekee kwa kuwaunganisha moja kwa moja mafundi wa mikono, vikundi vya sanaa za asili, na maeneo ya utalii wa kitamaduni wa vijijini na wanunuzi wao.">

                    Welcome to discover and enjoy the authentic richness of our culture through Asili Yetu Hub!
                    This platform is uniquely designed to solve key challenges by directly connecting local artisans,
                    traditional performance groups, and rural cultural tourism sites with their buyers.

                </p>

                <div class="pt-2 border-t border-amber-900/10 space-y-1.5 text-xs sm:text-sm text-gray-700">

                    <p>
                        <strong class="text-[#3D2314]"
                                data-en="Target Users:"
                                data-sw="Wanufaika Wakuu:">
                            Target Users:
                        </strong>

                        <span data-en="Primary users are local creators selling to make honest earnings. Secondary users are tourists and visitors looking for genuine items without high prices or middlemen."
                              data-sw="Watumiaji wakuu ni waundaji na mafundi wa ndani wanaotafuta njia sahihi ya kujipatia kipato. Wanufaika wengine ni watalii na wageni wanaotaka kununua bidhaa halisi bila gharama za madalali.">

                            Primary users are local creators selling to make honest earnings.
                            Secondary users are tourists and visitors looking for genuine items without high prices or middlemen.

                        </span>
                    </p>

                </div>
            </div>


     
            <div class="grid grid-cols-2 gap-3 sm:gap-5 relative shrink-0">

                <div class="animate-float-1 hover:scale-105 transition duration-300 drop-shadow-xl">
                    <img src="{{ asset('/assets/images/WhatsApp Image 2026-09-18 at 15.44.54 (1).png') }}"
                         alt="Wachezaji Wa Ngoma"
                         class="h-36 sm:h-52 object-contain mx-auto filter drop-shadow-lg">
                </div>

                <div class="animate-float-2 translate-y-3 hover:scale-105 transition duration-300 drop-shadow-xl">
                    <img src="{{ asset('/assets/images/WhatsApp Image 2026-09-18 at 15.44.54 (2).png') }}"
                         alt="Ngoma za Asili"
                         class="h-32 sm:h-48 object-contain mx-auto filter drop-shadow-lg">
                </div>

                <div class="animate-float-3 -translate-y-2 hover:scale-105 transition duration-300 drop-shadow-xl">
                    <img src="{{ asset('/assets/images/WhatsApp Image 2026-09-18 at 15.44.54 (3).png') }}"
                         alt="Mpiga Ngoma"
                         class="h-36 sm:h-52 object-contain mx-auto filter drop-shadow-lg">
                </div>

                <div class="animate-float-4 hover:scale-105 transition duration-300 drop-shadow-xl">
                    <img src="{{ asset('/assets/images/WhatsApp Image 2026-09-18 at 15.44.54.png') }}"
                         alt="Kilemba cha Asili"
                         class="h-36 sm:h-52 object-contain mx-auto filter drop-shadow-lg">
                </div>

            </div>

        </div>
    </div>
</div>



<main id="marketplace-section"
      class="w-full px-3 sm:px-5 lg:px-7 xl:px-9 py-5 sm:py-7 scroll-mt-20">

   
    <div class="w-full flex flex-col md:flex-row justify-between items-start md:items-center mb-4 sm:mb-5 border-b border-amber-900/10 pb-3 gap-3">

        <div>
            <h2 class="text-xl sm:text-2xl font-heading font-black text-[#3D2314]"
                data-en="Explore Authentic Crafts"
                data-sw="Chunguza Bidhaa za Asili">

                Explore Authentic Crafts

            </h2>

            <p class="text-xs sm:text-sm text-gray-600 mt-0.5"
               data-en="Discover items curated across Tanzania's artisan cooperatives"
               data-sw="Gundua bidhaa kutoka kwa vyama vya ushirika vya wasanii nchini Tanzania">

                Discover items curated across Tanzania's artisan cooperatives

            </p>
        </div>

        <span class="text-xs sm:text-sm font-bold text-amber-800 bg-amber-100 px-3 py-1.5 rounded-full self-end md:self-auto shadow-sm">

            {{ method_exists($products, 'total') ? number_format($products->total()) : $products->count() }}

            <span data-en="items available"
                  data-sw="bidhaa zinapatikana">
                items available
            </span>

        </span>

    </div>


    <form method="GET"
          action="{{ url('/#marketplace-section') }}"
          class="w-full bg-white/95 backdrop-blur rounded-2xl p-3 sm:p-4 shadow-sm border border-amber-900/10 mb-5">

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">

          
            <div class="relative">

                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    🔍
                </span>

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search craft, artisan or region..."
                       data-en-placeholder="Search craft, artisan or region..."
                       data-sw-placeholder="Tafuta bidhaa, fundi au mkoa..."
                       class="w-full pl-9 pr-3 py-2.5 text-sm bg-gray-50 border border-amber-900/15 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-600 focus:bg-white transition">

            </div>


          
            <div>

                <select name="category"
                        onchange="this.form.action='{{ url('/#marketplace-section') }}'; this.form.submit()"
                        class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-amber-900/15 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-600 focus:bg-white transition text-gray-700">

                    <option value="all"
                            data-en="All Categories"
                            data-sw="Aina Zote">
                        All Categories
                    </option>

                    <option value="Carvings"
                        {{ request('category') == 'Carvings' ? 'selected' : '' }}
                        data-en="Carvings"
                        data-sw="Wachongaji">
                        Carvings
                    </option>

                    <option value="Fabrics"
                        {{ request('category') == 'Fabrics' ? 'selected' : '' }}
                        data-en="Fabrics & Clothing"
                        data-sw="Vitambaa na Nguo">
                        Fabrics & Clothing
                    </option>

                    <option value="Pottery"
                        {{ request('category') == 'Pottery' ? 'selected' : '' }}
                        data-en="Pottery & Terracotta"
                        data-sw="Vyungu">
                        Pottery & Terracotta
                    </option>

                    <option value="Jewelry"
                        {{ request('category') == 'Jewelry' ? 'selected' : '' }}
                        data-en="Jewelry"
                        data-sw="Mapambo">
                        Jewelry
                    </option>

                    <option value="Beadwork"
                        {{ request('category') == 'Beadwork' ? 'selected' : '' }}
                        data-en="Maasai Beadwork"
                        data-sw="Ushanga wa Kimasai">
                        Maasai Beadwork
                    </option>

                    <option value="Painting"
                        {{ request('category') == 'Painting' ? 'selected' : '' }}
                        data-en="Tingatinga Art"
                        data-sw="Sanaa ya Tingatinga">
                        Tingatinga Art
                    </option>

                </select>

            </div>


           
            <div>

                <select name="sort"
                        onchange="this.form.action='{{ url('/#marketplace-section') }}'; this.form.submit()"
                        class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-amber-900/15 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-600 focus:bg-white transition text-gray-700">

                    <option value="latest"
                        {{ request('sort') == 'latest' ? 'selected' : '' }}
                        data-en="Sort by: Newest Arrivals"
                        data-sw="Pangilia: Mpya Zaidi">
                        Sort by: Newest Arrivals
                    </option>

                    <option value="price_low"
                        {{ request('sort') == 'price_low' ? 'selected' : '' }}
                        data-en="Price: Low to High"
                        data-sw="Bei: Ya Chini hadi Juu">
                        Price: Low to High
                    </option>

                    <option value="price_high"
                        {{ request('sort') == 'price_high' ? 'selected' : '' }}
                        data-en="Price: High to Low"
                        data-sw="Bei: Ya Juu hadi Chini">
                        Price: High to Low
                    </option>

                    <option value="popular"
                        {{ request('sort') == 'popular' ? 'selected' : '' }}
                        data-en="Most Popular"
                        data-sw="Maarufu Zaidi">
                        Most Popular
                    </option>

                </select>

            </div>

        </div>

    </form>


  
    @if($products->isEmpty())

        <div class="w-full bg-white/95 backdrop-blur rounded-2xl p-8 sm:p-12 text-center shadow-sm border border-amber-100">

            <div class="text-4xl mb-2">
                🏺
            </div>

            <h3 class="text-lg font-bold text-gray-800 mb-1"
                data-en="No products found"
                data-sw="Hakuna bidhaa zinapatikana">

                No products found

            </h3>

            <p class="text-gray-500 text-sm font-medium"
               data-en="No products uploaded yet or matching your filter query."
               data-sw="Hakuna bidhaa zilizopatikana bado au zinazolingana na utafutaji wako.">

                No products uploaded yet or matching your filter query.

            </p>

        </div>

    @else

        
        <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-3 sm:gap-4">

            @foreach($products as $product)

                <div class="bg-white rounded-2xl shadow-sm border border-amber-900/10 overflow-hidden flex flex-col justify-between hover:shadow-xl transition group">

                    <div>

                        
                        @if($product->image_path)

                            <div class="overflow-hidden bg-amber-50 cursor-pointer relative"
                                 onclick="openImageModal(
                                    '{{ asset('assets/uploads/' . basename($product->image_path)) }}',
                                    '{{ addslashes($product->title) }}'
                                 )">

                                <img src="{{ asset('/assets/uploads/' . basename($product->image_path)) }}"
                                     alt="{{ $product->title }}"
                                     loading="lazy"
                                     class="w-full h-40 sm:h-44 object-cover object-center group-hover:scale-105 transition duration-500">

                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-bold">
                                    <span>
                                        🔍 Bonyeza kuona picha kubwa
                                    </span>
                                </div>


                               
                                <button type="button"

                                    @if($product->stock_quantity > 0)

                                        onclick="addToCart(
                                            event,
                                            '{{ $product->id }}',
                                            '{{ route('cart.add', $product->id) }}'
                                        )"

                                    @else

                                        disabled
                                        onclick="event.preventDefault(); alert('This product is out of stock');"

                                    @endif

                                    title="Add to Cart"
                                    data-en-title="Add to Cart"
                                    data-sw-title="Weka Kwenye Kikapu"

                                    class="absolute top-2 right-2 w-9 h-9
                                    {{ $product->stock_quantity > 0
                                        ? 'bg-white/90 hover:bg-amber-600 hover:text-white'
                                        : 'bg-gray-300 cursor-not-allowed' }}
                                    text-amber-900 rounded-full shadow flex items-center justify-center transition backdrop-blur text-sm z-10">

                                    🛒

                                </button>

                            </div>

                        @else

                            <div class="w-full h-40 sm:h-44 bg-amber-50 flex items-center justify-center text-amber-700/40 text-sm font-medium relative">

                                <span data-en="No Image Available"
                                      data-sw="Hakuna Picha">
                                    No Image Available
                                </span>

                                <button type="button"

                                    @if($product->stock_quantity > 0)

                                        onclick="addToCart(
                                            event,
                                            '{{ $product->id }}',
                                            '{{ route('cart.add', $product->id) }}'
                                        )"

                                    @else

                                        disabled
                                        onclick="event.preventDefault(); alert('This product is out of stock');"

                                    @endif

                                    title="Add to Cart"

                                    class="absolute top-2 right-2 w-9 h-9
                                    {{ $product->stock_quantity > 0
                                        ? 'bg-white/90 hover:bg-amber-600 hover:text-white'
                                        : 'bg-gray-300 cursor-not-allowed' }}
                                    text-amber-900 rounded-full shadow flex items-center justify-center transition backdrop-blur text-sm z-10">

                                    🛒

                                </button>

                            </div>

                        @endif


                       
                        <div class="p-3 sm:p-3.5">

                            <div class="flex justify-end items-center gap-1.5 flex-wrap">

                                <span class="text-[10px] text-amber-800 font-bold bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-900/10 inline-flex items-center gap-1">

                                    <svg class="w-3 h-3 fill-current shrink-0"
                                         viewBox="0 0 24 24"
                                         xmlns="http://www.w3.org/2000/svg">

                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>

                                    </svg>

                                    {{ optional($product->user)->location ?? 'Tanzania' }}

                                </span>

                                <span class="text-[10px] font-bold bg-amber-100 text-amber-900 px-2 py-0.5 rounded-full uppercase tracking-wider">

                                    {{ $product->category }}

                                </span>

                            </div>


                            <h3 class="font-heading font-bold text-sm sm:text-base text-gray-900 mt-1.5 line-clamp-1">

                                {{ $product->title }}

                            </h3>


                            <p class="text-amber-700 font-extrabold text-xs sm:text-sm mt-0.5">

                                TZS {{ number_format($product->price, 2) }}

                            </p>


                           
                            @if($product->stock_quantity > 0)

                                <div class="flex justify-end items-center mt-1.5">

                                    <span class="bg-green-100 text-green-900 px-2 py-0.5 rounded-full inline-flex items-center gap-1 text-[10px] font-semibold">

                                        <svg class="w-3 h-3 fill-current"
                                             viewBox="0 0 24 24"
                                             xmlns="http://www.w3.org/2000/svg">

                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>

                                        </svg>

                                        <span data-en="{{ $product->getStockStatusAttribute() }}"
                                              data-sw="{{ $product->getStockStatusAttribute() }}">

                                            {{ $product->getStockStatusAttribute() }}

                                        </span>

                                    </span>

                                </div>

                            @else

                                <div class="flex justify-end mt-1.5">

                                    <span class="bg-red-100 text-red-900 px-2 py-0.5 rounded-full text-[10px] font-semibold">

                                        <span data-en="Out of Stock"
                                              data-sw="Hakuna Hisa">
                                            Out of Stock
                                        </span>

                                    </span>

                                </div>

                            @endif


                            <p class="text-xs text-gray-600 mt-1 line-clamp-2 leading-relaxed">

                                {{ $product->description }}

                            </p>

                        </div>

                    </div>


                    
                    <div class="p-3 bg-amber-50/40 border-t border-amber-900/5">

                        <a href="{{ route('products.show', $product->id) }}"
                           target="_blank"
                           class="w-full inline-block text-center bg-[#3D2314] hover:bg-[#2C180E] text-amber-100 font-bold text-xs py-2.5 px-3 rounded-xl shadow transition">

                            <span data-en="View Details & Reviews"
                                  data-sw="Angalia Taarifa na Maoni">

                                View Details & Reviews

                            </span>

                        </a>

                    </div>

                </div>

            @endforeach

        </div>


       
        @if(method_exists($products, 'hasPages') && $products->hasPages())

            <div class="mt-6">
                {{ $products->appends(request()->query())->links() }}
            </div>

        @endif

    @endif

</main>


<div id="imageZoomModal"
     class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4 hidden"
     onclick="closeImageModal()">

    <div class="relative max-w-4xl w-full max-h-[90vh] flex flex-col items-center"
         onclick="event.stopPropagation()">

        <button onclick="closeImageModal()"
                class="absolute -top-12 right-0 bg-white/20 hover:bg-white/40 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg transition">

            ✕

        </button>

        <img id="zoomedImageElement"
             src=""
             alt="Zoomed Product"
             class="max-w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl border border-white/10">

        <h4 id="zoomedImageTitle"
            class="text-amber-200 font-heading font-bold text-lg mt-3 text-center">
        </h4>

    </div>
</div>


<div id="productDetailModal"
     class="fixed inset-0 z-50 bg-black/80 flex items-center justify-center p-3 sm:p-4 hidden"
     onclick="closeProductDetailModal()">

    <div class="relative max-w-2xl w-full bg-[#FAF7F2] rounded-3xl overflow-hidden shadow-2xl border border-amber-900/20 max-h-[92vh] flex flex-col"
         onclick="event.stopPropagation()">

        <div class="bg-[#3D2314] px-5 py-3 flex justify-between items-center text-amber-100">

            <h3 class="font-heading font-bold text-lg tracking-wide"
                data-en="Craft Full Details & Reviews"
                data-sw="Taarifa Kamili na Maoni ya Bidhaa">

                Craft Full Details & Reviews

            </h3>

            <button onclick="closeProductDetailModal()"
                    class="bg-amber-900/60 hover:bg-amber-800 text-amber-200 w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition">

                ✕

            </button>

        </div>


        <div class="p-5 overflow-y-auto space-y-4">

            <div id="modalProductImageContainer"
                 class="w-full h-56 bg-amber-50 rounded-2xl overflow-hidden border border-amber-900/10 relative cursor-pointer"
                 onclick="openImageModal(
                    document.getElementById('modalProductImage').src,
                    document.getElementById('modalProductTitle').textContent
                 )">

                <img id="modalProductImage"
                     src=""
                     alt="Artwork"
                     class="w-full h-full object-cover object-center">

                <div class="absolute bottom-2 right-2 bg-black/60 text-white text-[10px] px-2 py-1 rounded-lg backdrop-blur">

                    Bonyeza kukuza picha

                </div>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                <div>

                    <div class="flex justify-end">

                        <span id="modalProductCategory"
                              class="text-[10px] font-bold bg-amber-200 text-amber-900 px-3 py-1 rounded-full uppercase tracking-wider">
                        </span>

                    </div>

                    <h2 id="modalProductTitle"
                        class="font-heading font-black text-xl text-[#3D2314] mt-1">
                    </h2>

                    <p id="modalProductPrice"
                       class="text-amber-800 font-extrabold text-base mt-1">
                    </p>

                </div>


                <div class="bg-white p-3 rounded-2xl border border-amber-900/10 shadow-sm space-y-1 text-xs">

                    <p class="font-bold text-gray-800 border-b pb-1 mb-1"
                       data-en="Artisan Profile"
                       data-sw="Taarifa za Fundi">

                        Artisan Profile

                    </p>

                    <p class="text-gray-600">
                        <span data-en="Name" data-sw="Jina">Name</span>:
                        <span id="modalArtisanName"
                              class="font-bold text-gray-900">
                        </span>
                    </p>

                    <p class="text-gray-600">
                        <span data-en="Location" data-sw="Eneo/Mahali">Location</span>:
                        <span id="modalArtisanLocation"
                              class="font-bold text-amber-900 bg-amber-100 px-2 py-0.5 rounded-md">
                        </span>
                    </p>

                    <p class="text-gray-600">
                        <span data-en="Phone" data-sw="Simu">Phone</span>:
                        <span id="modalArtisanPhone"
                              class="font-bold text-gray-900">
                        </span>
                    </p>

                    <p class="text-gray-600">
                        <span data-en="Email" data-sw="Barua pepe">Email</span>:
                        <span id="modalArtisanEmail"
                              class="font-bold text-gray-900">
                        </span>
                    </p>

                    <p class="text-gray-600">
                        <span data-en="Listed On" data-sw="Imewekwa Tarehe">Listed On</span>:
                        <span id="modalProductDate"
                              class="font-bold text-gray-900">
                        </span>
                    </p>

                </div>

            </div>


            <div>

                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1"
                    data-en="Description"
                    data-sw="Maelezo">

                    Description

                </h4>

                <p id="modalProductDescription"
                   class="text-sm text-gray-700 bg-white p-3 rounded-2xl border border-amber-900/10 leading-relaxed shadow-sm">
                </p>

            </div>


           
            <div class="border-t border-amber-900/10 pt-4 space-y-3">

                <h4 class="font-heading font-bold text-base text-[#3D2314]"
                    data-en="Customer Reviews & Ratings"
                    data-sw="Maoni na Ukadiriaji wa Wateja">

                    Customer Reviews & Ratings

                </h4>

                <div id="modalReviewsList"
                     class="space-y-2">
                </div>


                <button id="loadMoreReviewsBtn"
                        onclick="fetchNextReviewPage()"
                        class="hidden w-full py-2 bg-amber-100 hover:bg-amber-200 text-amber-900 text-xs font-bold rounded-xl transition">

                    ↓ Onyesha Maoni Zaidi

                </button>


               
                <form id="reviewForm"
                      onsubmit="submitProductReview(event)"
                      class="bg-white p-3 rounded-2xl border border-amber-900/10 shadow-sm space-y-2.5">

                    <input type="hidden"
                           id="reviewProductId"
                           name="product_id">

                    <h5 class="font-bold text-xs text-gray-800"
                        data-en="Leave a Review"
                        data-sw="Andika Maoni Yako">

                        Leave a Review

                    </h5>


                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">

                        <div>

                            <label class="block text-[11px] text-gray-600 mb-1"
                                   data-en="Your Name"
                                   data-sw="Jina Lako">
                                Your Name
                            </label>

                            <input type="text"
                                   id="reviewAuthor"
                                   required
                                   class="w-full px-3 py-2 text-xs bg-gray-50 border border-amber-900/15 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-600"
                                   placeholder="Weka jina lako...">

                        </div>


                        <div>

                            <label class="block text-[11px] text-gray-600 mb-1"
                                   data-en="Rating (1-5 Stars)"
                                   data-sw="Nyota (1-5)">
                                Rating (1-5 Stars)
                            </label>

                            <select id="reviewRating"
                                    class="w-full px-3 py-2 text-xs bg-gray-50 border border-amber-900/15 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-600">

                                <option value="5">
                                    ⭐⭐⭐⭐⭐ (5 - Bora Zaidi)
                                </option>

                                <option value="4">
                                    ⭐⭐⭐⭐ (4 - Nzuri Sana)
                                </option>

                                <option value="3">
                                    ⭐⭐⭐ (3 - Wastani)
                                </option>

                                <option value="2">
                                    ⭐⭐ (2 - Duni)
                                </option>

                                <option value="1">
                                    ⭐ (1 - Mbaya)
                                </option>

                            </select>

                        </div>

                    </div>


                    <div>

                        <label class="block text-[11px] text-gray-600 mb-1"
                               data-en="Your Comment"
                               data-sw="Maoni Yako">

                            Your Comment

                        </label>

                        <textarea id="reviewComment"
                                  rows="2"
                                  required
                                  class="w-full px-3 py-2 text-xs bg-gray-50 border border-amber-900/15 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-600"
                                  placeholder="Andika uzoefu wako kuhusu bidhaa hii...">
                        </textarea>

                    </div>


                    <button type="submit"
                            class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow transition"
                            data-en="Submit Review"
                            data-sw="Tuma Maoni">

                        Submit Review

                    </button>

                </form>

            </div>

        </div>

    </div>
</div>



<div id="toastNotification"
     class="fixed bottom-5 left-5 z-50 transform translate-y-20 opacity-0 transition-all duration-300 bg-[#3D2314] text-amber-100 px-4 py-3 rounded-xl shadow-2xl border border-amber-600/30 text-xs font-bold flex items-center space-x-2">

    <span>🛒</span>

    <span id="toastMessage">
        Imeongezwa kwenye kikapu!
    </span>

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
                     class="w-12 h-12 sm:w-14 sm:h-14 object-cover rounded-full border border-amber-700/60 shadow-md shrink-0">
               
               
                <span class="text-2xl sm:text-3xl font-artistic tracking-wider text-amber-300">
                    Asili Yetu Hub
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

       
        <div class="space-y-2">
            <h3 class="text-amber-300 font-semibold text-xs tracking-wider border-b border-amber-800/50 pb-2 uppercase"
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
            <h3 class="text-amber-300 font-semibold text-xs tracking-wider border-b border-amber-800/50 pb-2 uppercase"
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
            <h3 class="text-amber-300 font-semibold text-xs tracking-wider border-b border-amber-800/50 pb-2 uppercase"
                data-en="Contact Us"
                data-sw="Wasiliana Nasi">
                Contact Us
            </h3>

            <div class="space-y-1.5 text-xs text-amber-200/70">
                <p class="flex items-center space-x-2">
                    <svg class="w-4 h-4 fill-current text-amber-400 shrink-0"
                         viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
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

<script>
   
    window.addEventListener('load', () => {
        const loader = document.getElementById('page-loader');
        if (loader) {
            setTimeout(() => {
                loader.classList.add('fade-out');
            }, 800); 
        }
    });

    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {

        mobileMenuButton.addEventListener('click', () => {

            mobileMenu.classList.toggle('hidden');

        });

    }


    

    const slides = document.querySelectorAll('.hero-slide');

    let currentSlide = 0;

    function nextSlide() {

        if (slides.length > 0) {

            slides[currentSlide].classList.remove('active');

            currentSlide = (currentSlide + 1) % slides.length;

            slides[currentSlide].classList.add('active');

        }

    }

    if (slides.length > 0) {

        setInterval(nextSlide, 6000);

    }



    function openImageModal(imgSrc, title) {

        document.getElementById('zoomedImageElement').src = imgSrc;

        document.getElementById('zoomedImageTitle').textContent = title;

        document.getElementById('imageZoomModal').classList.remove('hidden');

    }


    function closeImageModal() {

        document.getElementById('imageZoomModal').classList.add('hidden');

    }



    async function addToCart(event, productId, routeUrl) {

        event.stopPropagation();

        const csrfToken =
            document.querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content');

        try {

            const response = await fetch(routeUrl, {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },

                body: JSON.stringify({})

            });

            const result = await response.json();

            if (response.status === 401 && result.requiresLogin) {

                showToast(
                    'Tafadhali login au jisajili kwanza.',
                    true
                );

                setTimeout(() => {

                    window.location.href = result.loginUrl;

                }, 700);

                return;
            }


            if (response.ok || result.success) {

                showToast('Added to cart!');

                const newCount =
                    result.cartCount !== undefined
                        ? result.cartCount
                        : null;

                if (newCount !== null) {

                    updateCartCounts(newCount);

                } else {

                    incrementCartCounts();

                }

            } else {

                showToast(
                    result.message || 'Failed to add.',
                    true
                );

            }

        } catch (err) {

            console.error('Error:', err);

            showToast(
                'Network error occurred.',
                true
            );

        }

    }


   
    function showToast(message, isError = false) {

        const toast =
            document.getElementById('toastNotification');

        const toastMsg =
            document.getElementById('toastMessage');

        toastMsg.textContent = message;

        if (isError) {

            toast.className =
                'fixed bottom-5 left-5 z-50 transform translate-y-0 opacity-100 transition-all duration-300 bg-red-900 text-white px-4 py-3 rounded-xl shadow-2xl border border-red-600/30 text-xs font-bold flex items-center space-x-2';

        } else {

            toast.className =
                'fixed bottom-5 left-5 z-50 transform translate-y-0 opacity-100 transition-all duration-300 bg-[#3D2314] text-amber-100 px-4 py-3 rounded-xl shadow-2xl border border-amber-600/30 text-xs font-bold flex items-center space-x-2';

        }

        setTimeout(() => {

            toast.className =
                'fixed bottom-5 left-5 z-50 transform translate-y-20 opacity-0 transition-all duration-300 bg-[#3D2314] text-amber-100 px-4 py-3 rounded-xl shadow-2xl border border-amber-600/30 text-xs font-bold flex items-center space-x-2';

        }, 3000);

    }


  

    function updateCartCounts(count) {

        [
            'cartCountBadgeDesktop',
            'cartCountBadgeMobile'
        ].forEach(id => {

            const badge =
                document.getElementById(id);

            if (!badge) return;

            badge.textContent = count;

            if (count > 0) {

                badge.classList.remove('hidden');

            } else {

                badge.classList.add('hidden');

            }

        });

    }


    function incrementCartCounts() {

        [
            'cartCountBadgeDesktop',
            'cartCountBadgeMobile'
        ].forEach(id => {

            const badge =
                document.getElementById(id);

            if (!badge) return;

            let current =
                parseInt(badge.textContent) || 0;

            current++;

            badge.textContent = current;

            badge.classList.remove('hidden');

        });

    }


    
    let currentReviewPage = 1;

    let activeProductId = null;


    function openProductDetailModal(data) {

        document.getElementById('modalProductTitle').textContent =
            data.title;

        document.getElementById('modalProductCategory').textContent =
            data.category;

        document.getElementById('modalProductPrice').textContent =
            data.price;

        document.getElementById('modalProductDescription').textContent =
            data.description;

        document.getElementById('modalArtisanName').textContent =
            data.artisanName;

        document.getElementById('modalArtisanPhone').textContent =
            data.artisanPhone;

        document.getElementById('modalArtisanEmail').textContent =
            data.artisanEmail;

        document.getElementById('modalArtisanLocation').textContent =
            data.artisanLocation;

        document.getElementById('modalProductDate').textContent =
            data.date;

        document.getElementById('reviewProductId').value =
            data.productId;


        activeProductId = data.productId;

        currentReviewPage = 1;


        const imgElement =
            document.getElementById('modalProductImage');

        if (data.image) {

            imgElement.src = data.image;

            imgElement.classList.remove('hidden');

        } else {

            imgElement.classList.add('hidden');

        }


        document.getElementById('modalReviewsList').innerHTML = '';

        fetchNextReviewPage();

        document
            .getElementById('productDetailModal')
            .classList.remove('hidden');

    }


    async function fetchNextReviewPage() {

        if (!activeProductId) return;

        const reviewsList =
            document.getElementById('modalReviewsList');

        const loadMoreBtn =
            document.getElementById('loadMoreReviewsBtn');

        try {

            const response =
                await fetch(
                    `/products/${activeProductId}/reviews?page=${currentReviewPage}`
                );

            const result =
                await response.json();


            if (result.success) {

                if (
                    result.data.length === 0 &&
                    currentReviewPage === 1
                ) {

                    reviewsList.innerHTML =
                        '<p class="text-gray-500 text-xs italic">Hakuna maoni bado kwa bidhaa hii. Kuwa wa kwanza kuandika!</p>';

                    loadMoreBtn.classList.add('hidden');

                    return;

                }


                result.data.forEach(review => {

                    const stars =
                        '⭐'.repeat(review.rating);

                    reviewsList.innerHTML += `

                        <div class="bg-white p-3 rounded-2xl border border-amber-900/10 text-xs shadow-sm">

                            <div class="flex justify-between items-center mb-1">

                                <span class="font-bold text-gray-900">

                                    ${review.author_name ||
                                      review.customer_name ||
                                      'Mteja / Customer'}

                                </span>

                                <span class="text-yellow-500 font-bold">

                                    ${stars}

                                </span>

                            </div>

                            <p class="text-gray-600">

                                ${review.comment}

                            </p>

                        </div>

                    `;

                });


                if (result.has_more) {

                    loadMoreBtn.classList.remove('hidden');

                    currentReviewPage++;

                } else {

                    loadMoreBtn.classList.add('hidden');

                }

            }

        } catch (err) {

            console.error(
                'Kosa la kupata maoni:',
                err
            );

        }

    }


    function closeProductDetailModal() {

        document
            .getElementById('productDetailModal')
            .classList.add('hidden');

    }


    

    async function submitProductReview(event) {

        event.preventDefault();

        const productId =
            document.getElementById('reviewProductId').value;

        const author =
            document.getElementById('reviewAuthor').value;

        const rating =
            parseInt(
                document.getElementById('reviewRating').value
            );

        const comment =
            document.getElementById('reviewComment').value;

        const csrfToken =
            document.querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content');


        try {

            const response = await fetch('/reviews', {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },

                body: JSON.stringify({

                    product_id: productId,
                    author_name: author,
                    rating: rating,
                    comment: comment

                })

            });


            const result =
                await response.json();


            if (result.success) {

                alert(result.message);

                const stars =
                    '⭐'.repeat(rating);

                const reviewsList =
                    document.getElementById('modalReviewsList');


                if (
                    reviewsList.innerHTML.includes(
                        'Hakuna maoni'
                    )
                ) {

                    reviewsList.innerHTML = '';

                }


                const newReviewHTML = `

                    <div class="bg-white p-3 rounded-2xl border border-amber-900/10 text-xs shadow-sm">

                        <div class="flex justify-between items-center mb-1">

                            <span class="font-bold text-gray-900">

                                ${author}

                            </span>

                            <span class="text-yellow-500 font-bold">

                                ${stars}

                            </span>

                        </div>

                        <p class="text-gray-600">

                            ${comment}

                        </p>

                    </div>

                `;


                reviewsList.insertAdjacentHTML(
                    'afterbegin',
                    newReviewHTML
                );


                document
                    .getElementById('reviewForm')
                    .reset();

            } else {

                alert(
                    result.message ||
                    'Imeshindikana kuhifadhi maoni.'
                );

            }

        } catch (error) {

            console.error('Error:', error);

            alert(
                'Kumetokea tatizo la kimtandao au seva.'
            );

        }

    }

</script>

</body>
</html>
