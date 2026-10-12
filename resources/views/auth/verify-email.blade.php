<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thibitisha Barua Pepe - Asili Yetu Hub</title>
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
                <h1 id="modal-title" class="font-black text-2xl text-[#3D2314]" style="font-family:'Playfair Display',serif">Thibitisha Barua Pepe</h1>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Asante kwa kujisajili! Tafadhali thibitisha anwani yako ya barua pepe kwa kubonyeza kiungo kilichotumwa.</p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-xs text-green-700 bg-green-50 p-3 rounded-xl border border-green-200">
                    {{ __('Kiungo kipya cha uthibitisho kimetumwa kwenye barua pepe yako.') }}
                </div>
            @endif

            <div class="mt-4 space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full bg-[#3D2314] hover:bg-[#2C180E] text-amber-100 py-3.5 rounded-xl font-bold text-sm transition shadow-md tracking-wide">
                        {{ __('Tuma Tena Barua Pepe ya Uthibitisho') }}
                    </button>
                </form>

                <div class="flex items-center justify-center pt-2 border-t border-gray-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-gray-600 hover:text-amber-800 font-semibold underline">
                            {{ __('Ondoka kwenye akaunti / Log Out') }}
                        </button>
                    </form>
                </div>
            </div>

            
            <div class="text-center pt-4 border-t border-gray-100 mt-4">
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center text-xs text-amber-900 font-bold hover:underline gap-1.5 transition">
                    <span style="font-size: 14px;">&larr;</span> Rudi kwenye ukurasa wa mwanzo
                </a>
            </div>

        </section>
    </main>
</body>
</html>
