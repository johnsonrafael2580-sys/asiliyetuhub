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
        <div class="bg-[#3D2314] -m-6 px-6 py-6 border-b border-amber-900/40 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-heading font-black text-2xl text-amber-100 tracking-wide" data-en="Initiate Order Fulfillment" data-sw="Kuanzisha Usafirishaji wa Mzigo">
                    Initiate Order Fulfillment
                </h2>
                <p class="text-xs sm:text-sm text-amber-200/80 mt-1 font-medium" data-en="Configure pickup from rural village and delivery destination for tourist order #{{ $productRequest->id }}." data-sw="Weka kituo cha kuchukua mzigo kijijini na anwani ya kufikisha kwa mtalii kwa oda #{{ $productRequest->id }}.">
                    Configure pickup from rural village and delivery destination for tourist order #{{ $productRequest->id }}.
                </p>
            </div>

            <a href="{{ route('artisan.dashboard') }}" class="px-4 py-2 text-xs font-bold text-amber-200 bg-amber-900/60 border border-amber-800/50 rounded-xl hover:bg-amber-900 transition flex items-center space-x-1 shadow-sm">
                <span>←</span>
                <span data-en="Cancel" data-sw="Ghairi">Cancel</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-wavy-pattern min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
           
            <div class="p-6 bg-white rounded-2xl border border-stone-200 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                <div class="flex items-center space-x-4">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-16 h-16 object-cover rounded-xl border border-stone-200">
                    @else
                       
                    @endif
                    <div>
                        <span class="inline-block text-xs font-bold uppercase tracking-wider text-amber-900 bg-amber-100/80 px-2.5 py-0.5 rounded-md border border-amber-200">
                            {{ $product->category ?? 'Craft' }}
                        </span>
                        <h3 class="text-lg font-bold text-stone-900 mt-1">{{ $product->title }}</h3>
                        <p class="text-sm text-stone-600 mt-0.5">
                            <strong class="text-stone-800">Customer:</strong> {{ $productRequest->customer_name ?? 'Tourist / Customer' }} 
                            @if($productRequest->customer_phone) <span class="text-stone-300">|</span> {{ $productRequest->customer_phone }} @endif
                        </p>
                    </div>
                </div>

                <div class="sm:text-right border-t sm:border-t-0 pt-4 sm:pt-0 border-stone-100 w-full sm:w-auto">
                    <span class="text-xs text-stone-500 font-medium block">Order Value</span>
                    <h4 class="text-2xl font-black text-amber-900 mt-0.5">
                        TZS {{ number_format($productRequest->subtotal ?? $product->price ?? 0, 2) }}
                    </h4>
                </div>
            </div>

           
            <div class="p-8 sm:p-10 bg-white rounded-2xl border border-stone-200 shadow-sm space-y-8">
                <header class="border-b border-stone-100 pb-5">
                    <h3 class="text-xl font-heading font-bold text-stone-900" data-en="Logistics & Delivery Configuration" data-sw="Mpangilio wa Usafirishaji">
                        Logistics & Delivery Configuration
                    </h3>
                    <p class="text-sm text-stone-500 mt-1" data-en="Provide rural dispatch and destination details to generate live tracking." data-sw="Weka taarifa za kituo cha kijijini na kituo cha kufikisha ili kuwezesha ufuatiliaji wa moja kwa moja.">
                        Provide rural dispatch and destination details to generate live tracking.
                    </p>
                </header>

                <form action="{{ route('fulfillments.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="product_request_id" value="{{ $productRequest->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                       
                        <div class="space-y-1.5">
                            <label for="pickup_location" class="block text-sm font-semibold text-stone-800" data-en="Rural Pickup Location (Village / Workshop)" data-sw="Kituo cha Kuchukua (Kijiji / Karakana)">
                                Rural Pickup Location <span class="text-amber-800">*</span>
                            </label>
                            <input type="text" name="pickup_location" id="pickup_location" required
                                placeholder="e.g. Mwenge Carvers Market, Shed 12, Dar es Salaam"
                                value="{{ old('pickup_location', 'Mwenge Artisan Workshop') }}"
                                class="block w-full rounded-xl border-stone-300 bg-white focus:border-amber-700 focus:ring-amber-700 text-sm py-2.5 px-3.5 text-stone-900 shadow-sm">
                            @error('pickup_location')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-stone-500" data-en="Specific village, cooperative hub or artisan workshop address." data-sw="Kijiji husika, kituo cha ushirika au karakana ya fundi.">Specific village, cooperative hub or artisan workshop address.</p>
                        </div>

                       
                        <div class="space-y-1.5">
                            <label for="delivery_location" class="block text-sm font-semibold text-stone-800" data-en="Delivery Destination (Tourist Hotel / Address)" data-sw="Kituo cha Kufikisha (Hoteli ya Mtalii / Anwani)">
                                Delivery Destination <span class="text-amber-800">*</span>
                            </label>
                            <input type="text" name="delivery_location" id="delivery_location" required
                                placeholder="e.g. Four Points by Sheraton, Room 302, Arusha"
                                value="{{ old('delivery_location', $productRequest->delivery_location ?? 'Tourist Hotel / Lodge') }}"
                                class="block w-full rounded-xl border-stone-300 bg-white focus:border-amber-700 focus:ring-amber-700 text-sm py-2.5 px-3.5 text-stone-900 shadow-sm">
                            @error('delivery_location')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-stone-500" data-en="Tourist hotel, lodge, airport pickup counter, or shipping address." data-sw="Hoteli ya mtalii, loji, kaunta ya uwanja wa ndege au anwani ya usafirishaji.">Tourist hotel, lodge, airport pickup counter, or shipping address.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Courier Partner -->
                        <div class="space-y-1.5">
                            <label for="courier_partner" class="block text-sm font-semibold text-stone-800" data-en="Courier / Logistics Carrier" data-sw="Msafirishaji / Kampuni ya Mizigo">
                                Courier / Logistics Carrier
                            </label>
                            <input type="text" name="courier_partner" id="courier_partner"
                                placeholder="e.g. Local Motorbike Rider, EMS Posta, DHL, Regional Bus Parcel"
                                value="{{ old('courier_partner', 'Posta EMS / Local Dispatch') }}"
                                class="block w-full rounded-xl border-stone-300 bg-white focus:border-amber-700 focus:ring-amber-700 text-sm py-2.5 px-3.5 text-stone-900 shadow-sm">
                            @error('courier_partner')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                       
                        <div class="space-y-1.5">
                            <label for="packaging_notes" class="block text-sm font-semibold text-stone-800" data-en="Packaging Notes" data-sw="Maelezo ya Ufungashaji">
                                Packaging Notes
                            </label>
                            <input type="text" name="packaging_notes" id="packaging_notes"
                                placeholder="e.g. Double-layer bubble wrap, wooden crate, banana-fiber sleeve"
                                value="{{ old('packaging_notes', 'Safe cushioned cultural packaging') }}"
                                class="block w-full rounded-xl border-stone-300 bg-white focus:border-amber-700 focus:ring-amber-700 text-sm py-2.5 px-3.5 text-stone-900 shadow-sm">
                            @error('packaging_notes')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    
                    <div class="space-y-1.5">
                        <label for="special_instructions" class="block text-sm font-semibold text-stone-800" data-en="Special Handling Instructions" data-sw="Maelekezo Maalum ya Utunzaji">
                            Special Handling Instructions
                        </label>
                        <textarea name="special_instructions" id="special_instructions" rows="3"
                            placeholder="e.g. Fragile ebony carving — do not place heavy items on top. Keep dry."
                            class="block w-full rounded-xl border-stone-300 bg-white focus:border-amber-700 focus:ring-amber-700 text-sm p-3.5 text-stone-900 shadow-sm">{{ old('special_instructions', 'Fragile handcrafted art. Handle with care.') }}</textarea>
                        @error('special_instructions')
                            <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-6 border-t border-stone-100 flex items-center justify-between gap-4">
                        <a href="{{ route('artisan.dashboard') }}" class="px-5 py-2.5 text-xs font-bold text-stone-600 hover:text-stone-900 rounded-xl hover:bg-stone-100 transition" data-en="Cancel" data-sw="Ghairi">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-wider text-white bg-amber-800 hover:bg-amber-900 transition shadow-md hover:shadow-lg flex items-center space-x-2">
                            <span data-en="Create Shipment & Start Tracking" data-sw="Anzisha Usafirishaji">Create Shipment & Start Tracking</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
