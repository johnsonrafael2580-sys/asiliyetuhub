<x-app-layout>
    @push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Playfair+Display:ital,wght@0,600;0,900;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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

        .font-artistic { font-family: 'Cinzel Decorative', serif; }
        .font-heading { font-family: 'Playfair Display', serif; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    @endpush

    <x-slot name="header">
        <div class="bg-[#3D2314] -m-6 px-6 py-6 border-b border-amber-800/30 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-heading font-black text-2xl sm:text-3xl text-amber-100 tracking-wide" data-en="Profile Management" data-sw="Usimamizi wa Wasifu">
                    Profile Management
                </h2>
                <p class="text-xs sm:text-sm text-amber-200/80 mt-1 font-medium" data-en="Manage your account settings, password, and security" data-sw="Simamia mipangilio ya akaunti yako, neno la siri na usalama">
                    Manage your account settings, password, and security
                </p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-xs font-bold text-amber-200 bg-amber-900/60 border border-amber-800/50 rounded-xl hover:bg-amber-900 transition flex items-center space-x-1 shadow-sm">
                    <span>←</span>
                    <span data-en="Back to Dashboard" data-sw="Rudi Dashibodi">Back to Dashboard</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10 sm:py-12 bg-wavy-pattern min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
           
            <div class="p-6 sm:p-10 bg-white shadow-sm border border-amber-900/10 rounded-2xl">
                @include('profile.partials.update-profile-information-form')
            </div>

           
            <div class="p-6 sm:p-10 bg-white shadow-sm border border-amber-900/10 rounded-2xl">
                @include('profile.partials.update-password-form')
            </div>

           
            <div class="p-6 sm:p-10 bg-white shadow-sm border border-amber-900/10 rounded-2xl">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>
