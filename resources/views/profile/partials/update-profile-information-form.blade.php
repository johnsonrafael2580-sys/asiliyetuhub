<section>
    <header class="border-b border-amber-900/10 pb-4 mb-6">
        <h2 class="text-xl font-heading font-bold text-[#3D2314]" data-en="Profile Information" data-sw="Taarifa za Wasifu">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600" data-en="Update your account's profile information and email address." data-sw="Sasisha taarifa za akaunti yako na barua pepe.">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6 max-w-3xl">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="name" :value="__('Name')" class="font-semibold text-xs uppercase tracking-wider text-gray-700" data-en="Name" data-sw="Jina" />
                <x-text-input id="name" name="name" type="text" class="mt-2 block w-full bg-gray-50/80 border-amber-900/15 focus:border-amber-600 focus:ring-amber-600 rounded-xl py-2.5" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" class="font-semibold text-xs uppercase tracking-wider text-gray-700" data-en="Email" data-sw="Barua Pepe" />
                <x-text-input id="email" name="email" type="email" class="mt-2 block w-full bg-gray-50/80 border-amber-900/15 focus:border-amber-600 focus:ring-amber-600 rounded-xl py-2.5" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('Phone')" class="font-semibold text-xs uppercase tracking-wider text-gray-700" data-en="Phone" data-sw="Simu" />
                <x-text-input id="phone" name="phone" type="text" class="mt-2 block w-full bg-gray-50/80 border-amber-900/15 focus:border-amber-600 focus:ring-amber-600 rounded-xl py-2.5" :value="old('phone', $user->phone)" autocomplete="tel" placeholder="+255..." />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <div>
                <x-input-label for="location" :value="__('Location / Eneo')" class="font-semibold text-xs uppercase tracking-wider text-gray-700" data-en="Location" data-sw="Eneo" />
                <div class="mt-2 flex gap-2">
                    <x-text-input id="location" name="location" type="text" class="block w-full bg-gray-50/80 border-amber-900/15 focus:border-amber-600 focus:ring-amber-600 rounded-xl py-2.5" :value="old('location', $user->location)" placeholder="e.g. Arusha, Tanzania" autocomplete="address-level2" />
                    <button type="button" id="detectLocationBtn" class="inline-flex items-center justify-center rounded-xl border border-[#3D2314] bg-[#3D2314] px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-white hove <!-- =========================================================
     FOOTER
========================================================= -->r:bg-[#2C180E] transition">Use my location</button>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('location')" />
            </div>

            <div>
                <x-input-label for="latitude" :value="__('Latitude (optional)')" class="font-semibold text-xs uppercase tracking-wider text-gray-700" data-en="Latitude" data-sw="Latitudo" />
                <x-text-input id="latitude" name="latitude" type="number" step="any" class="mt-2 block w-full bg-gray-50/80 border-amber-900/15 focus:border-amber-600 focus:ring-amber-600 rounded-xl py-2.5" :value="old('latitude', $user->latitude)" placeholder="-3.367" />
                <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
            </div>

            <div>
                <x-input-label for="longitude" :value="__('Longitude (optional)')" class="font-semibold text-xs uppercase tracking-wider text-gray-700" data-en="Longitude" data-sw="Longitudo" />
                <x-text-input id="longitude" name="longitude" type="number" step="any" class="mt-2 block w-full bg-gray-50/80 border-amber-900/15 focus:border-amber-600 focus:ring-amber-600 rounded-xl py-2.5" :value="old('longitude', $user->longitude)" placeholder="36.681" />
                <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
            </div>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl">
                <p class="text-sm text-amber-900" data-en="Your email address is unverified." data-sw="Barua pepe yako haijathibitishwa.">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline font-bold text-amber-900 hover:text-amber-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 ml-1" data-en="Click here to re-send the verification email." data-sw="Bofya hapa kutuma tena barua pepe ya uthibitisho.">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-emerald-700" data-en="A new verification link has been sent to your email address." data-sw="Kiungo kipya cha uthibitisho kimetumwa kwenye barua pepe yako.">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-3 bg-[#3D2314] hover:bg-[#2C180E] text-amber-100 font-bold rounded-xl shadow transition duration-200 text-xs uppercase tracking-wider cursor-pointer" data-en="Save Changes" data-sw="Hifadhi Mabadiliko">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm font-semibold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200"
                    data-en="Saved successfully."
                    data-sw="Imehifadhiwa kikamilifu."
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const detectBtn = document.getElementById('detectLocationBtn');
        const locationInput = document.getElementById('location');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');

        if (!detectBtn || !locationInput || !latitudeInput || !longitudeInput) return;

        detectBtn.addEventListener('click', function () {
            if (!navigator.geolocation) {
                alert('Your browser does not support location detection. Please enter your location manually.');
                return;
            }

            detectBtn.disabled = true;
            detectBtn.textContent = 'Detecting...';

            navigator.geolocation.getCurrentPosition(async function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                latitudeInput.value = lat;
                longitudeInput.value = lng;

                try {
                    co <!-- =========================================================
     FOOTER
========================================================= -->nst response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lng)}`);
                    const data = await response.json();

                    const placeName = data?.display_name || `${lat}, ${lng}`;
                    locationInput.value = placeName;
                } catch (error) {
                    locationInput.value = `${lat}, ${lng}`;
                } finally {
                    detectBtn.disabled = false;
                    detectBtn.textContent = 'Use my location';
                }
            }, function () {
                detectBtn.disabled = false;
                detectBtn.textContent = 'Use my location';
                alert('Location access was blocked. Please allow access or enter the artisan location manually.');
            }, {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 0
            });
        });
    });
</script>