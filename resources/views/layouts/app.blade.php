<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Asili Yetu Hub') }}</title>

   
    <script src="https://cdn.tailwindcss.com"></script>

   
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Playfair+Display:ital,wght@0,600;0,900;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

   
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes movePattern {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 120px 120px;
            }
        }

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
            background-color: #FAF7F2;

            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 20 Q 25 5, 50 20 T 100 20 M0 50 Q 25 35, 50 50 T 100 50 M0 80 Q 25 65, 50 80 T 100 80' fill='none' stroke='%23854d0e' stroke-width='1' stroke-opacity='0.08'/%3E%3Cpath d='M20 0 Q 5 25, 20 50 T 20 100 M50 0 Q 35 25, 50 50 T 50 100 M80 0 Q 65 25, 80 50 T 80 100' fill='none' stroke='%23854d0e' stroke-width='1' stroke-opacity='0.06'/%3E%3C/svg%3E");

            background-size: 120px 120px;

            animation: movePattern 25s linear infinite;

            overflow-x: hidden;
        }

        .font-artistic {
            font-family: 'Cinzel Decorative', serif;
        }

        .font-heading {
            font-family: 'Playfair Display', serif;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>


<body class="min-h-screen w-full text-gray-900 antialiased selection:bg-amber-600 selection:text-white m-0 p-0">

    <div class="min-h-screen w-full flex flex-col">


        
        <div class="w-full shrink-0">
            @include('layouts.navigation')
        </div>


       
        @isset($header)

            <header class="w-full shrink-0 bg-[#3D2314] text-amber-50 shadow-md border-b border-amber-800/30">

                <div class="w-full px-4 sm:px-6 lg:px-8 py-6">

                    <div class="w-full font-heading font-bold text-xl sm:text-2xl text-amber-100 tracking-wide">
                        {{ $header }}
                    </div>

                </div>

            </header>

        @endisset


        
        <main class="flex-1 w-full min-w-0">

            <div class="w-full min-w-0">

                {{ $slot }}

            </div>

        </main>


    </div>


    @stack('scripts')


    
    <script>
        (function () {

            const dict = {
                'Dashboard': 'Dashibodi',
                'Profile': 'Wasifu',
                'Log Out': 'Toka',
                'Commissions': 'Tume',
                'Shipments': 'Usafirishaji',
                'Channels': 'Njia',
                'Save': 'Hifadhi',
                'Cancel': 'Ghairi',
                'Delete Account': 'Futa Akaunti',
                'Update Password': 'Sasisha Nenosiri',
                'Profile Information': 'Taarifa za Wasifu',
                'Current Password': 'Nenosiri la Sasa',
                'New Password': 'Nenosiri Jipya',
                'Confirm Password': 'Thibitisha Nenosiri',
                'Email': 'Barua Pepe',
                'Name': 'Jina',
                'Phone': 'Simu',
                'Notifications': 'Arifa',
                'Order': 'Oda',
                'Orders': 'Oda',
                'Products': 'Bidhaa',
                'Product': 'Bidhaa',
                'Status': 'Hali',
                'Price': 'Bei',
                'Quantity': 'Idadi',
                'Delivered': 'Imekabidhiwa',
                'Pending': 'Inasubiri',
                'Processing': 'Inachakatwa',
                'Shipped': 'Imesafirishwa',
                'Available': 'Inapatikana',
                'Automatic Earnings': 'Mapato ya Moja kwa Moja',
                'Earnings & Commissions': 'Mapato na Tume',
                'View Earnings': 'Angalia Mapato',
                'View Wallet': 'Angalia Salio'
            };

            if ('{{ app()->getLocale() }}' !== 'sw') {
                return;
            }

            document
                .querySelectorAll('label,button,a,p,span,h1,h2,h3,h4,th,td')
                .forEach(el => {

                    if (el.children.length === 0) {

                        let t = el.textContent.trim();

                        if (dict[t]) {
                            el.textContent = el.textContent.replace(t, dict[t]);
                        }

                    }

                });

        })();
    </script>

</body>
</html>
