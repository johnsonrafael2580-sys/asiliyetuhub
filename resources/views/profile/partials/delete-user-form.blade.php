<section class="space-y-6">
    <header class="border-b border-amber-900/10 pb-4 mb-6">
        <h2 class="text-xl font-heading font-bold text-red-900" data-en="Delete Account" data-sw="Futa Akaunti">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600" data-en="Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain." data-sw="Mara tu akaunti yako inapofutwa, rasilimali na data zake zote zitafutwa kabisa. Kabla ya kufuta akaunti yako, tafadhali pakua data yoyote au taarifa unayotaka kubaki nayo.">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <div>
        <button type="button" 
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="px-6 py-3 bg-red-700 hover:bg-red-800 text-white font-bold rounded-xl shadow transition duration-200 text-xs uppercase tracking-wider cursor-pointer"
            data-en="Delete Account" data-sw="Futa Akaunti">
            {{ __('Delete Account') }}
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-8 bg-white rounded-2xl space-y-6">
            @csrf
            @method('delete')

            <div>
                <h2 class="text-lg font-heading font-bold text-gray-900" data-en="Are you sure you want to delete your account?" data-sw="Una uhakika unataka kufuta akaunti yako?">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600" data-en="Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account." data-sw="Mara tu akaunti yako inapofutwa, rasilimali na data zake zote zitafutwa kabisa. Tafadhali weka neno lako la siri ili kudhibitisha kuwa unataka kufuta akaunti yako kabisa.">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>
            </div>

            <div>
                <x-input-label for="password" value="{{ __('Password') }}" class="font-semibold text-xs uppercase tracking-wider text-gray-700" data-en="Password" data-sw="Neno la Siri" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-2 block w-full bg-gray-50 border-amber-900/15 focus:border-amber-600 focus:ring-amber-600 rounded-xl py-2.5"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition text-xs uppercase tracking-wider cursor-pointer" data-en="Cancel" data-sw="Ghairi">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="px-5 py-2.5 bg-red-700 hover:bg-red-800 text-white font-bold rounded-xl shadow transition text-xs uppercase tracking-wider cursor-pointer" data-en="Delete Account" data-sw="Futa Akaunti">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>