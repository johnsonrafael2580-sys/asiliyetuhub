<nav x-data="{ open: false }" class="bg-[#3D2314] border-b border-amber-800/30 shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 sm:h-20">
            
            
            <div class="flex items-center gap-3 sm:gap-6">
                <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('assets/images/logo.jpeg') }}" 
                         alt="Asili Yetu Hub Logo" 
                         class="w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full border border-amber-700/60 shadow-md shrink-0">
                    <span class="text-lg sm:text-2xl font-artistic text-amber-300 tracking-wider">Asili Yetu Hub</span>
                </a>

                <div class="hidden sm:flex items-center gap-2">
                    @auth
                        @if(auth()->user()->role === 'artisan')
                            <a href="{{ route('artisan.dashboard') }}" class="nav-link {{ request()->routeIs('artisan.dashboard') ? 'nav-link-active' : '' }}">Dashboard</a>
                            <a href="{{ route('fulfillments.index') }}" class="nav-link {{ request()->routeIs('fulfillments.*') ? 'nav-link-active' : '' }}">Shipments</a>
                            <a href="{{ route('commissions.index') }}" class="nav-link {{ request()->routeIs('commissions.*') ? 'nav-link-active' : '' }}">Earnings</a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'nav-link-active' : '' }}">Operations</a>
                        @else
                            <a href="{{ route('customer.dashboard') }}" class="nav-link {{ request()->routeIs('customer.dashboard') || request()->routeIs('dashboard') ? 'nav-link-active' : '' }}">Dashboard</a>
                            <a href="{{ route('cart.index') }}" class="nav-link {{ request()->routeIs('cart.*') ? 'nav-link-active' : '' }}">Cart</a>
                        @endif
                    @else
                        <a href="{{ route('home') }}" class="nav-link">Marketplace</a>
                    @endauth
                </div>
            </div>

           
            <div class="flex items-center gap-2 sm:gap-3">
                @include('components.language-toggle')

                @auth
                   
                    <div class="hidden sm:block">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-amber-800/50 text-sm rounded-xl text-amber-200 bg-[#2C180E] hover:text-white transition">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="fill-current h-4 w-4 ms-1" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">Profile / Wasifu</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out / Toka</x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="hidden sm:flex items-center gap-2">
                        <a href="{{ route('login') }}" class="text-xs font-bold text-amber-200 hover:text-white px-2 py-1">Login</a>
                        <a href="{{ route('register') }}" class="rounded-xl bg-amber-200 px-3 py-2 text-xs font-bold text-[#3D2314] hover:bg-amber-300">Register</a>
                    </div>
                @endauth

               
                <button @click="open = !open" class="sm:hidden inline-flex items-center justify-center p-2 rounded-xl text-amber-200 bg-amber-900/50 border border-amber-800/40 hover:bg-amber-800 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    
    <div x-show="open" x-transition class="sm:hidden bg-[#2C180E] border-t border-amber-900/40 px-4 py-4 space-y-2">
        @auth
            <div class="px-3 py-2 text-xs font-semibold text-amber-400 border-b border-amber-900/60 mb-2">
                Signed in as: <span class="text-white">{{ Auth::user()->name }}</span>
            </div>

            @if(auth()->user()->role === 'artisan')
                <a href="{{ route('artisan.dashboard') }}" class="mobile-nav-link">Dashboard</a>
                <a href="{{ route('fulfillments.index') }}" class="mobile-nav-link">Shipments</a>
                <a href="{{ route('commissions.index') }}" class="mobile-nav-link">Earnings</a>
            @elseif(auth()->user()->role === 'admin')
                <a href="{{ route('admin.payments.index') }}" class="mobile-nav-link">Operations</a>
            @else
                <a href="{{ route('customer.dashboard') }}" class="mobile-nav-link">Dashboard</a>
                <a href="{{ route('cart.index') }}" class="mobile-nav-link">Cart</a>
            @endif

            <a href="{{ route('profile.edit') }}" class="mobile-nav-link">Profile / Wasifu</a>
            
            <form method="POST" action="{{ route('logout') }}" class="pt-1">
                @csrf
                <button type="submit" class="w-full text-left mobile-nav-link text-red-300 hover:text-red-100">
                    Log Out / Toka
                </button>
            </form>
        @else
            <a href="{{ route('home') }}" class="mobile-nav-link">Marketplace</a>
            <div class="grid grid-cols-2 gap-2 pt-2">
                <a href="{{ route('login') }}" class="text-center py-2 px-3 rounded-xl border border-amber-700/50 text-amber-200 text-xs font-bold hover:bg-amber-900/40">Login</a>
                <a href="{{ route('register') }}" class="text-center py-2 px-3 rounded-xl bg-amber-200 text-[#3D2314] text-xs font-bold hover:bg-amber-300">Register</a>
            </div>
        @endauth
    </div>

    <style>
        .nav-link{padding:.5rem .75rem;border-radius:.75rem;font-size:.75rem;font-weight:700;color:rgba(253,230,138,.8);transition:.2s}
        .nav-link:hover,.nav-link-active{color:#fff;background:rgba(120,53,15,.75)}
        .mobile-nav-link{display:block;padding:.6rem .85rem;border-radius:.75rem;color:#fde68a;font-weight:700;font-size:.85rem;transition:.2s}
        .mobile-nav-link:hover{background:rgba(120,53,15,.75);color:#fff}
    </style>
</nav>
