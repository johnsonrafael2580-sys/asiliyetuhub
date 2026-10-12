<section>
    <header class="border-b border-amber-900/10 pb-4 mb-6">
        <h2 class="text-xl font-heading font-bold text-[#3D2314]" data-en="Update Password" data-sw="Badili Neno la Siri">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600" data-en="Ensure your account is using a long, random password to stay secure." data-sw="Hakikisha akaunti yako inatumia neno la siri refu na thabiti ili kuwa salama.">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6 max-w-3xl">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="font-semibold text-xs uppercase tracking-wider text-gray-700" data-en="Current Password" data-sw="Neno la Siri la Sasa" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-2 block w-full bg-gray-50/80 border-amber-900/15 focus:border-amber-600 focus:ring-amber-600 rounded-xl py-2.5" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="update_password_password" :value="__('New Password')" class="font-semibold text-xs uppercase tracking-wider text-gray-700" data-en="New Password" data-sw="Neno Jipya la Siri" />
                <x-text-input id="update_password_password" name="password" type="password" class="mt-2 block w-full bg-gray-50/80 border-amber-900/15 focus:border-amber-600 focus:ring-amber-600 rounded-xl py-2.5" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="font-semibold text-xs uppercase tracking-wider text-gray-700" data-en="Confirm Password" data-sw="Thibitisha Neno la Siri" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-2 block w-full bg-gray-50/80 border-amber-900/15 focus:border-amber-600 focus:ring-amber-600 rounded-xl py-2.5" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-3 bg-[#3D2314] hover:bg-[#2C180E] text-amber-100 font-bold rounded-xl shadow transition duration-200 text-xs uppercase tracking-wider cursor-pointer" data-en="Update Password" data-sw="Badilisha Neno la Siri">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm font-semibold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200"
                    data-en="Password updated."
                    data-sw="Neno la siri limebadilishwa."
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>