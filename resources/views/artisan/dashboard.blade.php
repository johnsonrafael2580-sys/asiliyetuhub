<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Asili Yetu Hub') }} - Artisan Dashboard</title>

        <!-- Tailwind CSS via CDN -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Playfair+Display:ital,wght@0,600;0,900;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

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

            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                overflow-x: hidden;
                margin: 0;
            }
            .font-artistic { font-family: 'Cinzel Decorative', serif; }
            .font-heading { font-family: 'Playfair Display', serif; }
        </style>
    </head>
    <body class="min-h-full flex flex-col text-gray-900 antialiased selection:bg-amber-600 selection:text-white bg-wavy-pattern">

       
        <div class="min-h-[calc(100vh-80px)] flex flex-col flex-1">

            
            @include('layouts.navigation')

            <!-- PAGE HEADER (Full-width breakout) -->
            <header class="relative w-screen left-1/2 -translate-x-1/2 bg-[#3D2314] text-amber-50 shadow-md border-b border-amber-800/35 px-4 sm:px-6 lg:px-8 py-6">
                <div class="max-w-[1500px] mx-auto w-full flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h2 class="font-heading font-black text-2xl text-amber-100 tracking-wide" data-en="Artisan Dashboard" data-sw="Dashibodi ya Fundi">
                            Artisan Dashboard
                        </h2>
                        <p class="text-xs sm:text-sm text-amber-200/90 mt-1 font-medium" data-en="Upload and manage your cultural products directly" data-sw="Pakia na udhibiti bidhaa zako za kitamaduni moja kwa moja">
                            Upload and manage your cultural products directly
                        </p>
                    </div>
                </div>
            </header>

           
            <main class="flex-1 w-full">
                <div class="w-screen relative left-1/2 -translate-x-1/2 px-3 sm:px-6 lg:px-8 xl:px-10 py-8">
                    <div class="max-w-[1500px] mx-auto space-y-8">
                        
                        @if(session('success'))
                            <div id="success-alert" class="flex items-center justify-between p-4 mb-4 text-sm text-[#3D2314] bg-amber-200 border border-amber-500 rounded-2xl shadow-md transition-all duration-500">
                                <div class="flex items-center space-x-3">
                                    <span class="font-bold">{{ session('success') }}</span>
                                </div>
                                <button onclick="document.getElementById('success-alert').remove()" class="text-[#3D2314] hover:text:black font-bold px-2 py-1">✕</button>
                            </div>
                        @endif
                        @if(session('error'))
                            <div id="error-alert" class="flex items-center justify-between p-4 mb-4 text-sm text-[#3D2314] bg-amber-100 border border-amber-400 rounded-2xl shadow-md">
                                <div class="flex items-center space-x-3">
                                    <span class="font-bold">{{ session('error') }}</span>
                                </div>
                                <button onclick="document.getElementById('error-alert').remove()" class="text-amber-900 font-bold px-2 py-1">✕</button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div id="validation-errors" class="p-4 mb-4 text-sm text-amber-900 bg-amber-50 border border-amber-300 rounded-2xl">
                                <div class="font-bold mb-2 text-amber-800">There were problems with your submission:</div>
                                <ul class="list-disc list-inside text-xs">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                       
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                          
                            <section class="col-span-1 sm:col-span-2 lg:col-span-4 mb-4" aria-labelledby="artisan-notifications-title">
                                @php
                                @endphp

                                <div class="overflow-hidden rounded-xl border border-amber-100 bg-[#FFFDFA] shadow-sm">
                                    <div class="flex flex-col gap-3 border-b-4 border-amber-300 bg-[#3D2314] px-4 py-4 text-white sm:flex-row sm:items-center sm:justify-between sm:px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-white/40 bg-white/10 text-xl" aria-hidden="true">🔔</div>
                                            <div>
                                                <h4 id="artisan-notifications-title" class="text-base font-bold tracking-wide">Taarifa za Mfumo</h4>
                                                <p class="mt-0.5 text-xs text-amber-100">Notifications &amp; important updates</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="inline-flex items-center rounded-full border border-amber-300/60 bg-amber-200 px-3 py-1 text-xs font-bold text-[#3D2314]">
                                                Unread / Hazijasomwa: {{ $artisanUnreadCount }}
                                            </span>
                                            @if($artisanUnreadCount > 0)
                                                <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                                                    @csrf
                                                    <button type="submit" class="rounded-md border border-white/50 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-white hover:text-[#3D2314]">
                                                        Mark all as read / Soma zote
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="p-3 sm:p-4">
                                        @if($artisanNotifications->isEmpty())
                                            <div class="rounded-lg border border-dashed border-amber-200 bg-[#FAF7F2] px-4 py-8 text-center">
                                                <div class="mb-2 text-3xl" aria-hidden="true">📭</div>
                                                <p class="text-sm font-semibold text-[#3D2314]">Hakuna taarifa mpya / No notifications yet</p>
                                                <p class="mt-1 text-xs text-[#8A7564]">System updates and product requests will appear here.</p>
                                            </div>
                                        @else
                                            <ul class="space-y-2">
                                                @foreach($artisanNotifications as $notification)
                                                    @php
                                                        $notificationTitle = data_get($notification->data, 'title', 'Taarifa ya Mfumo / System Notification');
                                                        $notificationMessage = data_get($notification->data, 'message', data_get($notification->data, 'body', 'You have a new update.'));
                                                        $isUnread = is_null($notification->read_at);
                                                    @endphp
                                                    <li class="relative rounded-lg border {{ $isUnread ? 'border-amber-200 bg-amber-50/60' : 'border-amber-100 bg-[#FFFDFA]' }} p-3 sm:p-4">
                                                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start">
                                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full {{ $isUnread ? 'bg-[#3D2314] text-white' : 'bg-[#F3E9DD] text-[#8A7564]' }}" aria-hidden="true">
                                                                @if($isUnread) <span class="text-lg">●</span> @else <span class="text-lg">✓</span> @endif
                                                            </div>
                                                            <div class="min-w-0 flex-1">
                                                                <div class="flex flex-wrap items-center gap-2">
                                                                    <h5 class="text-sm font-bold text-slate-900">{{ $notificationTitle }}</h5>
                                                                    @if($isUnread)
                                                                        <span class="rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-[#3D2314]">New / Mpya</span>
                                                                    @else
                                                                        <span class="rounded-full bg-[#F3E9DD] px-2 py-0.5 text-[10px] font-semibold text-[#8A7564]">Read / Imesomwa</span>
                                                                    @endif
                                                                </div>
                                                                <p class="mt-1 text-sm leading-relaxed text-[#6B5546]">{{ $notificationMessage }}</p>
                                                                <p class="mt-2 text-xs text-[#8A7564]">
                                                                    <span class="font-semibold">Date / Tarehe:</span>
                                                                    {{ $notification->created_at?->format('d M Y, H:i') }}
                                                                    <span class="mx-1">·</span>{{ $notification->created_at?->diffForHumans() }}
                                                                </p>
                                                            </div>
                                                            <div class="flex shrink-0 flex-wrap items-center gap-2 sm:justify-end">
                                                                @if($isUnread)
                                                                    <form method="POST" action="{{ route('notifications.mark-read', $notification->id) }}">
                                                                        @csrf
                                                                        <button type="submit" class="rounded-md bg-[#3D2314] px-3 py-2 text-xs font-semibold text-white transition hover:bg-[#2C180E]">Mark read</button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="mt-4 flex flex-col gap-3 border-t border-amber-100 pt-3 sm:flex-row sm:items-center sm:justify-between">
                                                <p class="text-xs text-[#6B5546]">
                                                    Showing {{ $artisanNotifications->firstItem() ?? 0 }}–{{ $artisanNotifications->lastItem() ?? 0 }} of {{ $artisanNotifications->total() }} notifications
                                                </p>
                                                @if($artisanNotifications->lastPage() > 1)
                                                    <nav class="flex flex-wrap items-center gap-1.5" aria-label="Notifications pagination">
                                                        @if($artisanNotifications->onFirstPage())
                                                            <span class="rounded-md border border-amber-100 px-3 py-2 text-xs text-[#9B8A7C]">Previous</span>
                                                        @else
                                                            <a href="{{ $artisanNotifications->previousPageUrl() }}" class="rounded-md border border-amber-300 px-3 py-2 text-xs font-semibold text-[#3D2314] transition hover:bg-amber-50">Previous</a>
                                                        @endif

                                                        @php
                                                            $notificationPageStart = max(1, $artisanNotifications->currentPage() - 1);
                                                            $notificationPageEnd = min($artisanNotifications->lastPage(), $artisanNotifications->currentPage() + 1);
                                                        @endphp
                                                        @if($notificationPageStart > 1)
                                                            <a href="{{ $artisanNotifications->url(1) }}" class="rounded-md border border-amber-200 px-3 py-2 text-xs font-semibold text-[#3D2314] hover:bg-amber-50">1</a>
                                                            @if($notificationPageStart > 2)<span class="px-1 text-xs text-[#8A7564]">…</span>@endif
                                                        @endif
                                                        @for($page = $notificationPageStart; $page <= $notificationPageEnd; $page++)
                                                            @if($page === $artisanNotifications->currentPage())
                                                                <span aria-current="page" class="rounded-md bg-[#3D2314] px-3 py-2 text-xs font-bold text-amber-50">{{ $page }}</span>
                                                            @else
                                                                <a href="{{ $artisanNotifications->url($page) }}" class="rounded-md border border-amber-200 px-3 py-2 text-xs font-semibold text-[#3D2314] hover:bg-amber-50">{{ $page }}</a>
                                                            @endif
                                                        @endfor
                                                        @if($notificationPageEnd < $artisanNotifications->lastPage())
                                                            @if($notificationPageEnd < $artisanNotifications->lastPage() - 1)<span class="px-1 text-xs text-[#8A7564]">…</span>@endif
                                                            <a href="{{ $artisanNotifications->url($artisanNotifications->lastPage()) }}" class="rounded-md border border-amber-200 px-3 py-2 text-xs font-semibold text-[#3D2314] hover:bg-amber-50">{{ $artisanNotifications->lastPage() }}</a>
                                                        @endif

                                                        @if($artisanNotifications->hasMorePages())
                                                            <a href="{{ $artisanNotifications->nextPageUrl() }}" class="rounded-md border border-amber-300 px-3 py-2 text-xs font-semibold text-[#3D2314] transition hover:bg-amber-50">Next</a>
                                                        @else
                                                            <span class="rounded-md border border-amber-100 px-3 py-2 text-xs text-[#9B8A7C]">Next</span>
                                                        @endif
                                                    </nav>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </section>
                           
                            <a href="{{ route('commissions.index') }}" class="group p-5 bg-white rounded-2xl border border-amber-300 shadow-sm hover:shadow-md hover:border-amber-700 transition flex flex-col justify-between">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#3D2314] bg-amber-200/80 px-2 py-0.5 rounded-full border border-amber-400">10% Post-Sale</span>
                                </div>
                                <div>
                                    <h3 class="font-heading font-bold text-[#3D2314] group-hover:text-amber-800 text-base" data-en="Earnings & Commissions" data-sw="Mapato Baada ya 10% ya makato ya mfumo">Earnings &amp; Commissions</h3>
                                    <span class="sr-only">Earnings & Commissions</span>
                                    <p class="text-xs text-amber-900/70 mt-1" data-en="Track sales, commission deductions & net balance" data-sw="Fuatilia mauzo, makato ya tume na salio halisi">Track sales, commission deductions & net balance</p>
                                </div>
                                <div class="mt-4 pt-3 border-t border-amber-100 flex items-center justify-between text-xs font-bold text-amber-900">
                                    <span data-en="View Earnings" data-sw="Angalia Mapato">View Earnings</span>
                                    <span>→</span>
                                </div>
                            </a>

                            
                            <a href="{{ route('fulfillments.index') }}" class="group p-5 bg-white rounded-2xl border border-amber-300 shadow-sm hover:shadow-md hover:border-amber-700 transition flex flex-col justify-between">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#3D2314] bg-amber-200/80 px-2 py-0.5 rounded-full border border-amber-400">Village → Tourist</span>
                                </div>
                                <div>
                                    <h3 class="font-heading font-bold text-[#3D2314] group-hover:text-amber-800 text-base" data-en="Fulfillments & Delivery" data-sw="Usafirishaji wa Bidhaa">Fulfillments & Delivery</h3>
                                    <p class="text-xs text-amber-900/70 mt-1" data-en="Package, dispatch, and track orders in real-time" data-sw="Funga vifurushi na fuatilia safari ya mzigo">Package, dispatch, and track orders in real-time</p>
                                </div>
                                <div class="mt-4 pt-3 border-t border-amber-100 flex items-center justify-between text-xs font-bold text-amber-900">
                                    <span data-en="Track Shipments" data-sw="Fuatilia Mizigo">Track Shipments</span>
                                    <span>→</span>
                                </div>
                            </a>
                            
                            
                            <a href="{{ route('whatsapp.configure') }}" class="group p-5 bg-white rounded-2xl border border-amber-300 shadow-sm hover:shadow-md hover:border-amber-700 transition flex flex-col justify-between">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#3D2314] bg-amber-200/80 px-2 py-0.5 rounded-full border border-amber-400">WhatsApp, USSD & SMS</span>
                                </div>
                                <div>
                                    <h3 class="font-heading font-bold text-[#3D2314] group-hover:text-amber-800 text-base" data-en="Upload Channels" data-sw="Njia za Kupakia">Upload Channels</h3>
                                    <p class="text-xs text-amber-900/70 mt-1" data-en="Configure WhatsApp alerts & feature phone USSD" data-sw="Sanidi ujumbe wa WhatsApp na njia ya USSD">Configure WhatsApp alerts & feature phone USSD</p>
                                </div>
                                <div class="mt-4 pt-3 border-t border-amber-100 flex items-center justify-between text-xs font-bold text-amber-900">
                                    <span data-en="Configure Channels" data-sw="Weka Mipangilio">Configure Channels</span>
                                    <span>→</span>
                                </div>
                            </a>
                        </div>

                        
                        <div class="p-6 sm:p-10 bg-white shadow-sm border border-amber-300 rounded-2xl space-y-6 mt-8">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-amber-200 pb-4">
                                <h2 class="text-xl font-heading font-bold text-[#3D2314]" data-en="Customer Orders & Requests" data-sw="Oda na Maombi ya Wateja">
                                    Customer Orders & Requests
                                </h2>
                                <span class="text-xs text-amber-900/70" data-en="Orders trigger 10% commission after delivery" data-sw="Makato ya 10% yanakatwa baada ya mzigo kukabidhiwa">Orders trigger 10% commission after delivery</span>
                            </div>

                            @if(!isset($productRequests) || $productRequests->isEmpty())
                                <div class="text-amber-900/70 text-sm">
                                    <p data-en="No product requests or orders received yet." data-sw="Hakuna oda au maombi ya bidhaa yaliyopokelewa bado.">Hakuna oda au maombi ya bidhaa yaliyopokelewa bado.</p>
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-sm text-[#3D2314]">
                                        <thead class="bg-amber-100 text-[#3D2314] uppercase text-xs">
                                            <tr>
                                                <th class="p-3 rounded-l-xl" data-en="Product / Order" data-sw="Bidhaa / Oda">Bidhaa / Oda</th>
                                                <th class="p-3" data-en="Customer Details" data-sw="Taarifa za Mteja">Taarifa za Mteja</th>
                                                <th class="p-3" data-en="Quantity & Price" data-sw="Idadi na Bei">Idadi na Bei</th>
                                                <th class="p-3 rounded-r-xl" data-en="Actions & Status" data-sw="Hatua na Hali">Actions & Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-amber-200">
                                            @foreach($productRequests as $item)
                                                <tr class="hover:bg-amber-50/60">
                                                    <td class="p-3 font-bold text-[#3D2314]">
                                                        {{ $item->product->title ?? $item->product_title ?? 'Cultural Product' }}
                                                    </td>
                                                    
                                                    <td class="p-3">
                                                        <div class="space-y-0.5">
                                                            <p class="font-bold text-[#3D2314]">{{ $item->customer_name ?? $item->customer->name ?? 'Mteja' }}</p>
                                                            <p class="text-xs text-amber-900 font-semibold"> {{ $item->customer_phone ?? $item->tourist_phone ?? 'Hakuna namba' }}</p>
                                                            @if($item->delivery_location)
                                                                <p class="text-[11px] text-amber-900/70 truncate max-w-xs">{{ $item->delivery_location }}</p>
                                                            @endif
                                                        </div>
                                                    </td>

                                                     <td class="p-3 text-xs">
    <span class="font-semibold text-amber-900/80">
        Idadi: {{ $item->orderItem->quantity ?? $item->quantity ?? 1 }}
    </span><br>
    <span class="text-[#3D2314] font-bold">
        TZS {{ number_format($item->orderItem->subtotal ?? $item->subtotal ?? $item->product->price ?? 0, 2) }}
    </span>
</td>
                                                    <td class="p-3">
                                                        <div class="flex flex-wrap items-center gap-2">
                                                            <form action="{{ route('artisan.orders.updateStatus', $item->id) }}" method="POST" class="flex items-center space-x-1">
                                                                @csrf
                                                                @method('PATCH')
                                                                <select name="status" class="text-xs bg-amber-50 border-amber-300 rounded-lg p-1 text-[#3D2314] font-bold focus:ring-amber-500 focus:border-amber-500">
                                                                    <option value="pending" {{ ($item->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                    <option value="confirmed" {{ ($item->status ?? '') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                                    <option value="processing" {{ ($item->status ?? '') == 'processing' ? 'selected' : '' }}>Processing</option>
                                                                    <option value="packaged" {{ ($item->status ?? '') == 'packaged' ? 'selected' : '' }}>Packaged</option>
                                                                    <option value="dispatched" {{ ($item->status ?? '') == 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                                                                    <option value="in_transit" {{ ($item->status ?? '') == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                                                                    <option value="out_for_delivery" {{ ($item->status ?? '') == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                                                    <option value="delivered" {{ ($item->status ?? '') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                                    <option value="cancelled" {{ ($item->status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                                </select>
                                                                <button type="submit" class="px-2.5 py-1 bg-[#3D2314] text-amber-100 text-[10px] font-bold rounded-lg hover:bg-[#2C180E] transition">
                                                                    Update
                                                                </button>
                                                            </form>

                                                            @if($item->fulfillment)
                                                                <a href="{{ route('fulfillments.show', $item->fulfillment->id) }}" class="px-2.5 py-1 bg-[#3D2314] hover:bg-[#2C180E] text-amber-100 text-[10px] font-bold rounded-lg transition whitespace-nowrap flex items-center space-x-1">
                                                                    <span data-en="Track" data-sw="Fuatilia">Track</span>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('fulfillments.create', $item->id) }}" class="px-2.5 py-1 bg-[#3D2314] hover:bg-[#2C180E] text-amber-100 text-[10px] font-bold rounded-lg transition whitespace-nowrap flex items-center space-x-1">
                                                                    <span data-en="Ship Order" data-sw="Safirisha">Ship Order</span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                       
                        <div class="p-6 sm:p-10 bg-white shadow-sm border border-amber-300 rounded-2xl">
                            <header class="border-b border-amber-200 pb-4 mb-6">
                                <h2 class="text-xl font-heading font-bold text-[#3D2314]" data-en="Upload New Craft or Product" data-sw="Weka Bidhaa Mpya ya Sanaa">
                                    Upload New Craft or Product
                                </h2>
                            </header>

                            <form method="post" action="{{ route('artisan.products.store') }}" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="title" class="block font-semibold text-xs uppercase tracking-wider mb-2 text-[#3D2314]" data-en="Product Name" data-sw="Jina la Bidhaa">Product Name</label>
                                        <x-text-input id="title" name="title" type="text" class="w-full bg-amber-50/50 border-amber-300 rounded-xl" required />
                                    </div>
                                    <div>
                                        <label for="category" class="block font-semibold text-xs uppercase tracking-wider mb-2 text-[#3D2314]" data-en="Category" data-sw="Aina ya Bidhaa">Category</label>
                                        <select id="category" name="category" class="w-full bg-amber-50/50 border-amber-300 rounded-xl text-[#3D2314] text-sm py-2.5" required>
                                            <option value="Carvings" data-en="Carvings (e.g., Makonde Ebony Wood Sculptures)" data-sw="Kinyago (mf. Vinyago vya Mbao vya Makonde)">
                                                Carvings (e.g., Makonde Ebony Wood Sculptures)
                                            </option>
                                            <option value="Fabrics" data-en="Fabrics & Clothing (e.g., Authentic Hand-woven Maasai Shúkà)" data-sw="Mavazi na Kitambaa (mf. Shuka za Kimaasai)">
                                                Fabrics & Clothing (e.g., Authentic Hand-woven Maasai Shúkà)
                                            </option>
                                            <option value="Pottery" data-en="Pottery & Terracotta (e.g., Handcrafted Traditional Cooking Pots)" data-sw="Ufinyanzi (mf. Majungu na Vyungu vya Udongo)">
                                                Pottery & Terracotta (e.g., Handcrafted Traditional Cooking Pots)
                                            </option>
                                            <option value="Jewelry" data-en="Jewelry (e.g., Traditional Brass & Bone Bangles)" data-sw="Mapambo & Urembo (mf. Bangili za Shaba na Mifupa)">
                                                Jewelry (e.g., Traditional Brass & Bone Bangles)
                                            </option>
                                            <option value="Beadwork" data-en="Maasai Beadwork (e.g., Hand-beaded Ceremonial Necklaces)" data-sw="Ushanga wa Kimaasai (mf. Mikufu ya Ushanga)">
                                                Maasai Beadwork (e.g., Hand-beaded Ceremonial Necklaces)
                                            </option>
                                            <option value="Painting" data-en="Tingatinga Art (e.g., Vibrant Hand-painted Wildlife Canvas)" data-sw="Sanaa ya Tingatinga (mf. Michoro ya Wanyama)">
                                                Tingatinga Art (e.g., Vibrant Hand-painted Wildlife Canvas)
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="price" class="block font-semibold text-xs uppercase tracking-wider mb-2 text-[#3D2314]" data-en="Price (TZS)" data-sw="Bei (TZS)">Price (TZS)</label>
                                        <x-text-input id="price" name="price" type="number" step="0.01" class="w-full bg-amber-50/50 border-amber-300 rounded-xl" required />

                                        <label for="stock_quantity" class="block font-semibold text-xs uppercase tracking-wider mb-2 text-[#3D2314] mt-4" data-en="Stock Quantity" data-sw="Idadi ya Hisa">Stock Quantity</label>
                                        <x-text-input id="stock_quantity" name="stock_quantity" type="number" min="0" step="1" value="1" class="w-40 bg-amber-50/50 border-amber-300 rounded-xl" required />
                                    </div>
                                    <div>
                                        <label for="image" class="block font-semibold text-xs uppercase tracking-wider mb-2 text-[#3D2314]" data-en="Product Picture" data-sw="Picha ya Bidhaa">Product Picture</label>
                                        <input id="image" name="image" type="file" class="w-full text-sm text-[#3D2314] file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-amber-200 file:text-[#3D2314] cursor-pointer bg-amber-50/50 border border-amber-300 rounded-xl p-1.5" />
                                    </div>
                                </div>

                                <div>
                                    <label for="description" class="block font-semibold text-xs uppercase tracking-wider mb-2 text-[#3D2314]" data-en="Description" data-sw="Maelezo ya Kina">Description</label>
                                    <textarea id="description" name="description" class="w-full bg-amber-50/50 border-amber-300 rounded-xl shadow-sm text-sm p-3 text-[#3D2314]" rows="3" placeholder="Describe materials used, dimensions, and cultural background..." required></textarea>
                                </div>

                                <div class="flex items-center justify-end pt-2">
                                    <button type="submit" class="px-6 py-3 bg-[#3D2314] hover:bg-[#2C180E] text-amber-100 font-bold rounded-xl shadow transition duration-200 text-sm" data-en="Upload Product" data-sw="Pakia Bidhaa">
                                        Upload Product
                                    </button>
                                </div>
                            </form>
                        </div>

                        
                        <div class="p-6 sm:p-10 bg-white shadow-sm border border-amber-300 rounded-2xl space-y-6">
                            <h2 class="text-xl font-heading font-bold text-[#3D2314] border-b border-amber-200 pb-4" data-en="Your Listings" data-sw="Bidhaa Ulizoweka">
                                Your Listings
                            </h2>

                            @if(!isset($products) || $products->isEmpty())
                                <div class="text-center py-10">
                                    <div class="text-3xl mb-2">🏺</div>
                                    <p class="text-amber-900/70 text-sm font-medium" data-en="You have not uploaded any products yet." data-sw="Hujapakia bidhaa yoyote bado.">You have not uploaded any products yet.</p>
                                </div>
                            @else
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                    @foreach($products as $product)
                                        <div class="bg-white rounded-2xl border border-amber-300 overflow-hidden shadow-sm flex flex-col justify-between">
                                            <div>
                                                @if($product->image_path)
                                                    <div class="w-full h-36 bg-amber-100 overflow-hidden cursor-pointer relative group" onclick="openDashboardImageModal('{{ asset('assets/uploads/' . basename($product->image_path)) }}', '{{ addslashes($product->title) }}')">
                                                        <img src="{{ asset('assets/uploads/' . basename($product->image_path)) }}" alt="{{ $product->title }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-300">
                                                        <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-amber-100 text-[10px] font-bold">Zoom</div>
                                                    </div>
                                                @else
                                                    <div class="w-full h-36 bg-amber-100 flex flex-col items-center justify-center text-amber-900 p-2 text-center">
                                                        <span class="text-2xl mb-1">🪵</span>
                                                        <span class="text-[11px] font-bold truncate max-w-[200px]">{{ $product->title }}</span>
                                                        <span class="text-[9px] text-amber-800">Real Object Preview</span>
                                                    </div>
                                                @endif
                                                <div class="p-4">
                                                    <span class="text-[10px] font-bold bg-amber-100 text-[#3D2314] px-2.5 py-1 rounded-full uppercase tracking-wider border border-amber-300">{{ $product->category }}</span>
                                                    <h3 class="font-heading font-bold text-base text-[#3D2314] mt-2 line-clamp-1">{{ $product->title }}</h3>
                                                    <p class="text-amber-900 font-extrabold text-sm mt-0.5">TZS {{ number_format($product->price, 2) }}</p>
                                                    <p class="text-xs text-amber-900/80 mt-1.5 line-clamp-2">{{ $product->description }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="p-4 bg-amber-50/60 border-t border-amber-200 flex justify-between items-center mt-2">
                                                <span class="text-xs text-amber-900 font-semibold">Active Listing</span>
                                                <form action="{{ route('artisan.products.destroy', $product) }}" method="POST" onsubmit="return confirmDelete();">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-amber-100 hover:text-white text-xs font-bold bg-[#3D2314] hover:bg-[#2C180E] px-3 py-1.5 rounded-lg transition shadow-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if(method_exists($products, 'hasPages') && $products->hasPages())
                                    <div class="mt-6">
                                        {{ $products->appends(request()->query())->links() }}
                                    </div>
                                @endif
                            @endif
                        </div>

                    </div>
                </div>
            </main>

        </div>

       
        <div id="dashImageModal" class="fixed inset-0 z-50 bg-[#3D2314]/95 flex items-center justify-center p-4 hidden" onclick="closeDashboardImageModal()">
            <div class="relative max-w-3xl w-full flex flex-col items-center" onclick="event.stopPropagation()">
                <button onclick="closeDashboardImageModal()" class="absolute -top-12 right-0 bg-[#3D2314] hover:bg-[#2C180E] text-amber-100 w-10 h-10 rounded-full flex items-center justify-center font-bold border border-amber-700">✕</button>
                <img id="dashZoomedImage" src="" alt="Zoomed" class="max-w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl border-2 border-amber-700">
                <h4 id="dashZoomedTitle" class="text-amber-200 font-bold text-base mt-3"></h4>
            </div>
        </div>

       
        <script>
            function confirmDelete() {
                return confirm(@json(app()->getLocale()) === 'en' ? 'Are you sure you want to delete this product?' : 'Una uhakika unataka kufuta bidhaa hii?');
            }

            function openDashboardImageModal(src, title) {
                document.getElementById('dashZoomedImage').src = src;
                document.getElementById('dashZoomedTitle').textContent = title;
                document.getElementById('dashImageModal').classList.remove('hidden');
            }

            function closeDashboardImageModal() {
                document.getElementById('dashImageModal').classList.add('hidden');
            }
        </script>
    </body>
</html>
