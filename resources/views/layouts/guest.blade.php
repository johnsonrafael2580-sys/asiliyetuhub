<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Asili Yetu Hub') }}</title>

   
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
          rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Playfair+Display:ital,wght@0,600;0,900;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    
    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

       
        html,
        body {
            width: 100%;
            min-width: 100%;
            min-height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-artistic {
            font-family: 'Cinzel Decorative', serif;
        }

        .font-heading {
            font-family: 'Playfair Display', serif;
        }


        

        @keyframes movePattern {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 120px 120px;
            }
        }

        .auth-background {
            background-color: #3D2314;

            background-image:
                url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 20 Q 25 5, 50 20 T 100 20 M0 50 Q 25 35, 50 50 T 100 50 M0 80 Q 25 65, 50 80 T 100 80' fill='none' stroke='%23d6a84f' stroke-width='1' stroke-opacity='0.10'/%3E%3Cpath d='M20 0 Q 5 25, 20 50 T 20 100 M50 0 Q 35 25, 50 50 T 50 100 M80 0 Q 65 25, 80 50 T 80 100' fill='none' stroke='%23d6a84f' stroke-width='1' stroke-opacity='0.08'/%3E%3C/svg%3E");

            background-size: 120px 120px;

            animation: movePattern 25s linear infinite;

            overflow-x: hidden;
        }

    </style>
</head>


<body class="min-h-screen w-full m-0 p-0 text-gray-900 antialiased selection:bg-amber-600 selection:text-white">


    
    <div class="min-h-screen w-full flex flex-col auth-background">


       
        <div class="w-full shrink-0">

            <div class="w-full px-5 sm:px-8 lg:px-10 py-4">

                <div class="w-full flex justify-end">

                    @if (!request()->routeIs('login', 'register'))

                        @include('components.language-toggle')

                    @endif

                </div>

            </div>

        </div>


        
        <main class="flex-1 w-full flex flex-col items-center justify-center px-4 sm:px-6 py-8">


            
            <div class="mb-8 text-center">

                <a href="/" class="inline-block">

                    <span class="text-3xl sm:text-4xl lg:text-5xl font-artistic text-amber-300 tracking-wider">
                        Asili Yetu Hub
                    </span>

                </a>

            </div>


           
            <div class="w-full sm:max-w-md px-6 sm:px-8 py-8 bg-white shadow-2xl overflow-hidden rounded-2xl border border-amber-900/10">

                {{ $slot }}

            </div>


            
            <div class="mt-8 text-center">

                <a href="/"
                   class="text-xs sm:text-sm font-medium text-amber-200/80 hover:text-white transition">

                    &larr; Back to Marketplace / Rudi kwenye Duka Kuu

                </a>

            </div>


        </main>


       
        <footer class="w-full shrink-0 px-5 sm:px-8 lg:px-10 py-5">

            <div class="w-full text-center text-xs text-amber-200/50">

                © {{ date('Y') }} Asili Yetu Hub

            </div>

        </footer>


    </div>


    <script>
        (function () {

            const dict = {

                'Log in': 'Ingia',

                'Register': 'Jisajili',

                'Email Address': 'Barua Pepe',

                'Password': 'Nenosiri',

                'Remember me': 'Nikumbuke',

                'Forgot your password?': 'Umesahau nenosiri?',

                'Confirm Password': 'Thibitisha Nenosiri',

                'Name': 'Jina',

                'Phone': 'Simu',

                'Already registered?': 'Umesajili tayari?',

                'Reset Password': 'Weka Upya Nenosiri',

                'Save': 'Hifadhi',

                'Cancel': 'Ghairi',

                'Back to Marketplace / Rudi kwenye Duka Kuu': 'Rudi kwenye Soko'

            };


            const lang = '{{ app()->getLocale() }}';

            if (lang !== 'sw') {
                return;
            }


            document
                .querySelectorAll('label,button,a,p,span,h1,h2,h3')
                .forEach(el => {

                    if (el.children.length === 0) {

                        const t = el.textContent.trim();

                        if (dict[t]) {

                            el.textContent =
                                el.textContent.replace(t, dict[t]);

                        }

                    }

                });

        })();
    </script>

</body>

</html>
