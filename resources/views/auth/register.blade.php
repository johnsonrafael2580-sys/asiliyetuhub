<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jisajili - Asili Yetu Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; min-height: 100vh; overflow: hidden; }
        .welcome-background {
            position: fixed; inset: 0; width: 100%; height: 100%;
            border: 0; z-index: 0; background: #FAF7F2;
        }
        .register-backdrop {
            position: fixed; inset: 0; z-index: 1;
            display: flex; align-items: center; justify-content: center;
            padding: 12px; overflow-y: auto;
            background: rgba(35, 20, 12, .30);
            -webkit-backdrop-filter: blur(7px);
            backdrop-filter: blur(7px);
        }
        .register-modal {
            position: relative; width: 100%; max-width: 420px;
            max-height: calc(100vh - 24px); overflow-y: auto;
            background: rgba(255, 253, 249, .97);
            border: 1px solid rgba(255,255,255,.75);
            border-radius: 18px; padding: 20px 18px;
            box-shadow: 0 25px 80px rgba(25, 13, 7, .38);
            animation: modalIn .25s ease-out;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(12px) scale(.985); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @media (max-width: 480px) {
            .register-modal { padding: 16px 14px; border-radius: 16px; }
        }
    </style>
</head>
<body>
    <iframe class="welcome-background" src="{{ url('/') }}" title="Asili Yetu Hub welcome page" aria-hidden="true"></iframe>

    <main class="register-backdrop">
        <section class="register-modal" role="dialog" aria-modal="true" aria-labelledby="register-title">
            <div class="text-center mb-4 border-b border-gray-100 pb-3">
                <h1 id="register-title" class="font-black text-xl text-[#3D2314]" style="font-family:'Playfair Display',serif">Unda Akaunti</h1>
                <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">Jisajili ili uweze kunufaika na huduma zetu za Asili Yetu Hub.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-2.5">
                @csrf

                <div>
                    <label for="name" class="block font-bold text-[11px] text-gray-700 uppercase tracking-wider mb-0.5">Jina Kamili</label>
                    <input id="name" class="block w-full rounded-lg border-gray-200 bg-gray-50 focus:border-[#3D2314] focus:ring-[#3D2314] text-xs py-2 px-3 shadow-sm" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <div>
                    <label for="email" class="block font-bold text-[11px] text-gray-700 uppercase tracking-wider mb-0.5">Barua Pepe (Email)</label>
                    <input id="email" class="block w-full rounded-lg border-gray-200 bg-gray-50 focus:border-[#3D2314] focus:ring-[#3D2314] text-xs py-2 px-3 shadow-sm" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div>
                    <label for="phone" class="block font-bold text-[11px] text-gray-700 uppercase tracking-wider mb-0.5">Namba ya Simu</label>
                    <input id="phone" class="block w-full rounded-lg border-gray-200 bg-gray-50 focus:border-[#3D2314] focus:ring-[#3D2314] text-xs py-2 px-3 shadow-sm" type="text" name="phone" value="{{ old('phone') }}" placeholder="+255..." required autocomplete="tel" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                </div>

                <div>
                    <label for="role" class="block font-bold text-[11px] text-gray-700 uppercase tracking-wider mb-0.5">Aina ya Akaunti</label>
                    <select id="role" name="role" required class="block w-full rounded-lg border-gray-200 bg-gray-50 focus:border-[#3D2314] focus:ring-[#3D2314] text-xs py-2 px-3 shadow-sm">
                        <option value="customer" @selected(old('role', 'customer') === 'customer')>Customer / Mteja</option>
                        <option value="artisan" @selected(old('role') === 'artisan')>Artisan / Fundi</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-1" />
                </div>

                <div>
                    <label for="password" class="block font-bold text-[11px] text-gray-700 uppercase tracking-wider mb-0.5">Nenosiri</label>
                    <input id="password" class="block w-full rounded-lg border-gray-200 bg-gray-50 focus:border-[#3D2314] focus:ring-[#3D2314] text-xs py-2 px-3 shadow-sm" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div>
                    <label for="password_confirmation" class="block font-bold text-[11px] text-gray-700 uppercase tracking-wider mb-0.5">Thibitisha Nenosiri</label>
                    <input id="password_confirmation" class="block w-full rounded-lg border-gray-200 bg-gray-50 focus:border-[#3D2314] focus:ring-[#3D2314] text-xs py-2 px-3 shadow-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-[#3D2314] hover:bg-[#2C180E] text-amber-100 py-2.5 rounded-lg font-bold text-xs transition shadow-md tracking-wide">
                        {{ __('Jisajili Sasa') }}
                    </button>
                </div>
            </form>

            <div class="text-center pt-3 border-t border-gray-100 mt-3">
                <p class="text-[11px] text-gray-600">Una akaunti tayari? 
                    <a href="{{ route('login') }}" class="text-amber-800 font-bold hover:underline">Ingia hapa</a>
                </p>
            </div>

           
            <div class="text-center pt-2 mt-1">
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center text-[11px] text-amber-900 font-bold hover:underline gap-1.5 transition">
                    <span style="font-size: 13px;">&larr;</span> Rudi kwenye ukurasa wa mwanzo
                </a>
            </div>

        </section>
    </main>
</body>
</html>
