<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Weka Neno Jipya - Asili Yetu Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; min-height: 100vh; overflow: hidden; }
        .welcome-background {
            position: fixed; inset: 0; width: 100%; height: 100%;
            border: 0; z-index: 0; background: #FAF7F2;
        }
        .login-backdrop {
            position: fixed; inset: 0; z-index: 1;
            display: flex; align-items: center; justify-content: center;
            padding: 20px; overflow-y: auto;
            background: rgba(35, 20, 12, .30);
            -webkit-backdrop-filter: blur(7px);
            backdrop-filter: blur(7px);
        }
        .login-modal {
            position: relative; width: 100%; max-width: 460px;
            max-height: calc(100vh - 40px); overflow-y: auto;
            background: rgba(255, 253, 249, .97);
            border: 1px solid rgba(255,255,255,.75);
            border-radius: 22px; padding: 28px;
            box-shadow: 0 25px 80px rgba(25, 13, 7, .38);
            animation: modalIn .25s ease-out;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(12px) scale(.985); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @media (max-width: 480px) {
            .login-modal { padding: 22px 18px; border-radius: 18px; }
        }
    </style>
</head>
<body>
    <iframe class="welcome-background" src="{{ url('/') }}" title="Asili Yetu Hub welcome page" aria-hidden="true"></iframe>

    <main class="login-backdrop">
        <section class="login-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <div class="text-center mb-6 border-b border-gray-100 pb-4">
                <h1 id="modal-title" class="font-black text-2xl text-[#3D2314]" style="font-family:'Playfair Display',serif">Weka Neno Jipya</h1>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Tafadhali jaza taarifa zako hapa chini ili kuweka neno jipya la siri kwenye akaunti yako.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label for="email" class="block font-bold text-xs text-gray-700 uppercase tracking-wider mb-1">Barua pepe (Email)</label>
                    <input id="email" class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-[#3D2314] focus:ring-[#3D2314] text-sm py-3 px-4 shadow-sm" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div>
                    <label for="password" class="block font-bold text-xs text-gray-700 uppercase tracking-wider mb-1">Neno Jipya la Siri (Password)</label>
                    <input id="password" class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-[#3D2314] focus:ring-[#3D2314] text-sm py-3 px-4 shadow-sm" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div>
                    <label for="password_confirmation" class="block font-bold text-xs text-gray-700 uppercase tracking-wider mb-1">Thibitisha Neno la Siri</label>
                    <input id="password_confirmation" class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-[#3D2314] focus:ring-[#3D2314] text-sm py-3 px-4 shadow-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                
                <div class="pt-2">
                    <button type="submit" class="w-full bg-[#3D2314] hover:bg-[#2C180E] text-amber-100 py-3.5 rounded-xl font-bold text-sm transition shadow-md tracking-wide">
                        {{ __('Badilisha Neno la Siri') }}
                    </button>
                </div>
            </form>

           
            <div class="text-center pt-4 border-t border-gray-100 mt-4">
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center text-xs text-amber-900 font-bold hover:underline gap-1.5 transition">
                    <span style="font-size: 14px;">&larr;</span> Rudi kwenye ukurasa Mkuu
                </a>
            </div>

        </section>
    </main>
</body>
</html>
