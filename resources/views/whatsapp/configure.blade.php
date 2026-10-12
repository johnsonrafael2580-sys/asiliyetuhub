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
                    <span data-en="Multi-Channel &amp; WhatsApp Settings" data-sw="Mipangilio ya Multi-Channel &amp; WhatsApp">
                        Multi-Channel &amp; WhatsApp Settings
                    </span>
                </h2>
                <p class="text-xs sm:text-sm text-amber-200/80 mt-1 font-medium">
                    <span data-en="Choose how you want to upload products and receive order notifications." data-sw="Chagua njia utakayotumia kupakia bidhaa na kupokea taarifa za oda.">
                        Choose how you want to upload products and receive order notifications.
                    </span>
                </p>
            </div>

            <a href="{{ route('artisan.dashboard') }}"
               class="px-4 py-2 text-xs font-bold text-amber-200 bg-amber-900/60 border border-amber-800/50 rounded-xl hover:bg-amber-900 transition flex items-center gap-2">
                ←
                <span data-en="Back to Dashboard" data-sw="Rudi Dashibodi">
                    Back to Dashboard
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-wavy-pattern min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

           
            @if(session('success'))
                <div class="mb-6 p-4 bg-amber-50 border border-amber-300 text-amber-900 rounded-2xl text-sm font-semibold">
                    ✓ {{ session('success') }}
                </div>
            @endif

            
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-300 text-red-900 rounded-2xl text-sm font-semibold">
                    ⚠ {{ session('error') }}
                </div>
            @endif

            
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-300 text-red-900 rounded-2xl text-sm">
                    <ul class="list-disc ml-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="p-6 sm:p-10 bg-white rounded-2xl border border-amber-900/10 shadow-sm">

                <form id="channel-form" action="{{ route('whatsapp.settings.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div>
                        <h3 class="text-sm font-bold text-[#3D2314] uppercase tracking-wide mb-4">
                            <span data-en="Select Upload Channel" data-sw="Chagua Njia ya Kupakia Bidhaa">
                                Select Upload Channel
                            </span>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                           
                            <label class="channel-card p-5 rounded-2xl border-2 cursor-pointer transition flex flex-col justify-between space-y-3
                                {{ old('upload_method', $settings->upload_method ?? 'web') === 'web' ? 'border-[#3D2314] bg-amber-50/50 shadow-sm' : 'border-amber-900/10 hover:border-amber-300' }}">
                                <div class="flex items-start gap-3">
                                    <input type="radio" name="upload_method" value="web" class="mt-1 text-[#3D2314] focus:ring-[#3D2314]"
                                           {{ old('upload_method', $settings->upload_method ?? 'web') === 'web' ? 'checked' : '' }}>
                                    <div>
                                        <h4 class="font-bold text-[#3D2314]">
                                            <span data-en="Web Portal" data-sw="Tovuti">Web Portal</span>
                                        </h4>
                                        <p class="text-xs text-gray-600 mt-1">
                                            <span data-en="Upload products using the AsiliYetuHub website." data-sw="Pakia bidhaa kupitia tovuti ya AsiliYetuHub.">
                                                Upload products using the AsiliYetuHub website.
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </label>

                            
                            <label class="channel-card p-5 rounded-2xl border-2 cursor-pointer transition flex flex-col justify-between space-y-3
                                {{ old('upload_method', $settings->upload_method ?? 'web') === 'whatsapp' ? 'border-[#3D2314] bg-amber-50/50 shadow-sm' : 'border-amber-900/10 hover:border-amber-300' }}">
                                <div class="flex items-start gap-3">
                                    <input type="radio" name="upload_method" value="whatsapp" class="mt-1 text-[#3D2314] focus:ring-[#3D2314]"
                                           {{ old('upload_method', $settings->upload_method ?? 'web') === 'whatsapp' ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-[#3D2314]">WhatsApp</h4>
                                        <p class="text-xs text-gray-600 mt-1">
                                            <span data-en="Save and open WhatsApp to communicate with AsiliYetuHub." data-sw="Hifadhi kisha fungua WhatsApp kuwasiliana na AsiliYetuHub.">
                                                Save and open WhatsApp to communicate with AsiliYetuHub.
                                            </span>
                                        </p>
                                        <div class="mt-3 flex items-center justify-between pt-2 border-t border-amber-900/10">
                                            <span class="text-xs font-bold text-[#3D2314]">0698088657</span>
                                            <a href="https://wa.me/255698088657" target="_blank" rel="noopener noreferrer" onclick="event.stopPropagation();"
                                               class="text-xs font-bold text-[#3D2314] underline hover:text-amber-800">
                                                Fungua WhatsApp ↗
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            
                            <label class="channel-card p-5 rounded-2xl border-2 cursor-pointer transition flex flex-col justify-between space-y-3
                                {{ old('upload_method', $settings->upload_method ?? 'web') === 'sms' ? 'border-[#3D2314] bg-amber-50/50 shadow-sm' : 'border-amber-900/10 hover:border-amber-300' }}">
                                <div class="flex items-start gap-3">
                                    <input type="radio" name="upload_method" value="sms" class="mt-1 text-[#3D2314] focus:ring-[#3D2314]"
                                           {{ old('upload_method', $settings->upload_method ?? 'web') === 'sms' ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-[#3D2314]">SMS</h4>
                                        <p class="text-xs text-gray-600 mt-1">
                                            <span data-en="Open the phone SMS application." data-sw="Fungua programu ya SMS kwenye simu.">
                                                Open the phone SMS application.
                                            </span>
                                        </p>
                                        <div class="mt-3 flex items-center justify-between pt-2 border-t border-amber-900/10">
                                            <span class="text-xs font-bold text-[#3D2314]">0626684257</span>
                                            <a href="sms:+255626684257" onclick="event.stopPropagation();"
                                               class="text-xs font-bold text-[#3D2314] underline hover:text-amber-800">
                                                Fungua SMS ↗
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            
                            <label class="channel-card p-5 rounded-2xl border-2 cursor-pointer transition flex flex-col justify-between space-y-3
                                {{ old('upload_method', $settings->upload_method ?? 'web') === 'manager' ? 'border-[#3D2314] bg-amber-50/50 shadow-sm' : 'border-amber-900/10 hover:border-amber-300' }}">
                                <div class="flex items-start gap-3">
                                    <input type="radio" name="upload_method" value="manager" class="mt-1 text-[#3D2314] focus:ring-[#3D2314]"
                                           {{ old('upload_method', $settings->upload_method ?? 'web') === 'manager' ? 'checked' : '' }}>
                                    <div>
                                        <h4 class="font-bold text-[#3D2314]">
                                            <span data-en="Cooperative Manager" data-sw="Msimamizi wa Kikundi">
                                                Cooperative Manager
                                            </span>
                                        </h4>
                                        <p class="text-xs text-gray-600 mt-1">
                                            <span data-en="A cooperative manager can help upload products." data-sw="Msimamizi wa kikundi anaweza kusaidia kupakia bidhaa.">
                                                A cooperative manager can help upload products.
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </label>

                        </div>
                    </div>

                   
                    <div class="border-t border-amber-900/10 pt-6 space-y-4">
                        <h4 class="text-xs font-bold text-[#3D2314] uppercase tracking-wide">
                            <span data-en="Notification Preferences" data-sw="Mipangilio ya Taarifa">
                                Notification Preferences
                            </span>
                        </h4>

                        <label class="flex items-center gap-3 text-sm text-amber-950 cursor-pointer">
                            <input type="checkbox" name="whatsapp_enabled" value="1"
                                   {{ old('whatsapp_enabled', $settings->whatsapp_enabled ?? true) ? 'checked' : '' }}
                                   class="rounded border-amber-900/30 text-[#3D2314] focus:ring-[#3D2314]">
                            <span data-en="Enable automated communication notifications" data-sw="Washa taarifa za mawasiliano otomatiki">
                                Enable automated communication notifications
                            </span>
                        </label>

                        <label class="flex items-center gap-3 text-sm text-amber-950 cursor-pointer">
                            <input type="checkbox" name="receive_product_alerts" value="1"
                                   {{ old('receive_product_alerts', $settings->receive_product_alerts ?? true) ? 'checked' : '' }}
                                   class="rounded border-amber-900/30 text-[#3D2314] focus:ring-[#3D2314]">
                            <span data-en="Receive product, delivery and earnings notifications" data-sw="Pokea taarifa za bidhaa, usafirishaji na mapato">
                                Receive product, delivery and earnings notifications
                            </span>
                        </label>
                    </div>

                   
                    <div class="pt-6 border-t border-amber-900/10 flex items-center justify-between gap-4">
                        <a href="{{ route('artisan.dashboard') }}" class="text-xs font-bold text-amber-900/70 hover:text-amber-900 transition">
                            ← <span data-en="Back" data-sw="Rudi">Back</span>
                        </a>

                        <button type="submit"
                                class="px-8 py-3 rounded-xl font-bold text-xs uppercase tracking-wider text-white bg-[#3D2314] hover:bg-amber-900 transition shadow-md">
                            <span data-en="Save & Continue" data-sw="Hifadhi na Endelea">
                                Save & Continue
                            </span>
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cards = document.querySelectorAll('.channel-card');
            const radios = document.querySelectorAll('input[name="upload_method"]');

            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    cards.forEach(card => {
                        card.classList.remove('border-[#3D2314]', 'bg-amber-50/50', 'shadow-sm');
                        card.classList.add('border-amber-900/10');
                    });

                    if (this.checked) {
                        const parentCard = this.closest('.channel-card');
                        if (parentCard) {
                            parentCard.classList.remove('border-amber-900/10');
                            parentCard.classList.add('border-[#3D2314]', 'bg-amber-50/50', 'shadow-sm');
                        }
                    }
                });
            });
        });
    </script>

</x-app-layout>
