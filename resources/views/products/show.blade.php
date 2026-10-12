<x-app-layout>
    {{-- Background CSS na Animation kutoka Welcome Page --}}
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

        .product-main-media {
            max-height: 72vh;
        }

        @media (max-width: 640px) {
            .product-main-media {
                aspect-ratio: 1 / 1;
                max-height: 52vh;
            }

            .gallery-thumb {
                width: 4.25rem;
                height: 4.25rem;
            }
        }
    </style>

    <div class="min-h-screen bg-wavy-pattern pb-16">

        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            @if(session('success'))
                <div class="mb-4 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800 shadow-xs">
                    <div class="flex h-7 w-7 items-center justify-center rounded-full bg-green-100 font-bold text-xs">✓</div>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 shadow-xs">
                    <div class="flex h-7 w-7 items-center justify-center rounded-full bg-red-100 font-bold text-xs">!</div>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif
        </div>

        
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">

            {{-- Breadcrumb --}}
            <nav class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-gray-500 mb-5">
                <a href="{{ url('/') }}" class="hover:text-[#3D2314] transition">Nyumbani</a>
                <span>›</span>
                <span class="hover:text-[#3D2314] transition">{{ $product->category }}</span>
                <span>›</span>
                <span class="font-semibold text-[#3D2314] truncate max-w-[200px] sm:max-w-none">{{ $product->title }}</span>
            </nav>

            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 lg:gap-8 items-start">
                <div class="xl:col-span-7">
                    <div class="rounded-3xl border border-[#E8DFD1] bg-white shadow-sm overflow-hidden p-3 sm:p-4">
                        <div class="relative bg-[#F3EEE5] aspect-[4/3] sm:aspect-[16/10] overflow-hidden rounded-2xl product-main-media">
                            <div class="absolute top-3 left-3 z-10">
                                <span class="inline-flex items-center rounded-full bg-[#3D2314] px-3 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-white shadow-sm">
                                    {{ $product->category }}
                                </span>
                            </div>

                            <img id="mainViewer" src="{{ asset('assets/uploads/' . basename($product->image_path ?? $product->image)) }}" class="w-full h-full object-cover transition duration-300" oncontextmenu="return false;" draggable="false" alt="{{ $product->title }}">

                            <div class="absolute bottom-3 right-3 rounded-full bg-black/55 px-3 py-1 text-[10px] font-semibold text-white">
                                Product Gallery
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="flex items-center gap-2.5 overflow-x-auto pb-1">
                                <button type="button" onclick="changeMainImage('{{ asset('assets/uploads/' . basename($product->image_path ?? $product->image)) }}', this)" class="gallery-thumb group relative h-18 w-18 sm:h-20 sm:w-20 shrink-0 overflow-hidden rounded-xl border-2 border-[#3D2314] bg-[#F8F4EE] transition">
                                    <img src="{{ asset('assets/uploads/' . basename($product->image_path ?? $product->image)) }}" class="w-full h-full object-cover" draggable="false" alt="{{ $product->title }}">
                                </button>

                                @foreach($product->galleryImages ?? [] as $gImg)
                                    <button type="button" onclick="changeMainImage('{{ asset('assets/uploads/' . basename($gImg->image_path)) }}', this)" class="gallery-thumb group relative h-18 w-18 sm:h-20 sm:w-20 shrink-0 overflow-hidden rounded-xl border-2 border-transparent bg-[#F8F4EE] transition hover:border-[#3D2314]">
                                        <img src="{{ asset('assets/uploads/' . basename($gImg->image_path)) }}" class="w-full h-full object-cover" draggable="false" alt="{{ $product->title }}">
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="xl:col-span-5">
                    <div class="xl:sticky xl:top-6 rounded-3xl border border-[#E8DFD1] bg-white p-5 sm:p-6 shadow-sm">
                        <div class="space-y-5">
                            <div>
                                <p class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-[#3D2314]/65">Authentic artisan product</p>
                                <h1 class="mt-2 text-2xl sm:text-3xl font-heading font-black leading-tight text-[#3D2314]">{{ $product->title }}</h1>
                            </div>

                            <div class="flex items-center justify-between gap-3">
                                <div class="text-2xl sm:text-3xl font-black text-[#3D2314]">TZS {{ number_format($product->price, 2) }}</div>
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[10px] font-bold border {{ $product->stock_quantity > 0 ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                                    {{ $product->stock_quantity > 0 ? $product->getStockStatusAttribute() : 'Out of stock' }}
                                </span>
                            </div>

                            <div class="rounded-2xl border border-amber-200 bg-amber-50/70 p-4">
                                <div class="flex items-center justify-between gap-3 mb-3">
                                    <div>
                                        <p class="text-[10px] uppercase tracking-[0.18em] text-amber-900/70 font-bold">Request this item</p>
                                        <h2 class="mt-1 text-lg font-heading font-black text-[#3D2314]">Direct order & payment</h2>
                                    </div>
                                    <span class="rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 px-2.5 py-1 text-[10px] font-bold">AUTO PAY</span>
                                </div>

                                @auth
                                    @if(in_array(auth()->user()->role, ['customer', 'tourist'], true))
                                        <form method="POST" action="{{ route('product.request', $product) }}" class="space-y-3">
                                            @csrf
                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-[10px] font-extrabold uppercase tracking-wider text-gray-600 mb-1">Quantity</label>
                                                    <input name="quantity" type="number" min="1" max="{{ max(1, (int) $product->stock_quantity) }}" value="1" required class="w-full rounded-xl border-amber-200 bg-white text-sm focus:border-[#3D2314] focus:ring-[#3D2314]">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-extrabold uppercase tracking-wider text-gray-600 mb-1">Delivery city</label>
                                                    <input name="delivery_location" type="text" value="{{ old('delivery_location', auth()->user()->location ?? '') }}" required placeholder="Mji / eneo" class="w-full rounded-xl border-amber-200 bg-white text-sm focus:border-[#3D2314] focus:ring-[#3D2314]">
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-[10px] font-extrabold uppercase tracking-wider text-gray-600 mb-1">Product details</label>
                                                <textarea name="message" rows="3" required maxlength="2000" placeholder="Rangi, ukubwa, custom, au maelezo ya delivery..." class="w-full rounded-xl border-amber-200 bg-white text-sm focus:border-[#3D2314] focus:ring-[#3D2314]"></textarea>
                                            </div>

                                            <div class="flex items-center justify-between rounded-xl border border-white/60 bg-white/70 px-3 py-2.5 text-xs text-gray-700">
                                                <span>Total</span>
                                                <strong class="text-[#3D2314]">TZS {{ number_format($product->price, 2) }} × quantity</strong>
                                            </div>

                                            <button type="submit" {{ $product->stock_quantity < 1 ? 'disabled' : '' }} class="w-full rounded-xl bg-[#3D2314] hover:bg-[#2C180E] disabled:opacity-50 text-white font-bold px-5 py-3 text-sm shadow-md transition">
                                                {{ $product->stock_quantity > 0 ? 'Request & Pay Now →' : 'Out of stock' }}
                                            </button>
    
                                        </form>
                                    @else
                                        <p class="text-xs text-gray-600">Tumia akaunti ya customer kufanya request ya bidhaa.</p>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="block w-full rounded-xl bg-[#3D2314] text-white text-center font-bold px-5 py-3 text-sm">Login to request & pay</a>
                                @endauth
                            </div>

                            <div class="rounded-2xl border border-[#E8DFD1] bg-[#FAF7F2] p-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-11 w-11 rounded-full bg-[#F0E5D7] text-[#3D2314] flex items-center justify-center font-black border border-[#E8DFD1]">
                                        {{ strtoupper(substr($product->user->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[10px] uppercase tracking-[0.18em] text-gray-500">Artisan</p>
                                        <h3 class="text-sm font-bold text-[#3D2314] truncate">{{ $product->user->name ?? 'Artisan' }}</h3>
                                    </div>
                                </div>

                                <div class="mt-3 flex flex-wrap gap-2 text-[11px] text-gray-600">
                                    @if(isset($product->user->phone))
                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-white border border-[#E8DFD1] px-2.5 py-1.5">☎ {{ $product->user->phone }}</span>
                                    @endif
                                    @if(isset($product->user->location))
                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-white border border-[#E8DFD1] px-2.5 py-1.5">📍 {{ $product->user->location }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 xl:grid-cols-12 gap-6">
                <div class="xl:col-span-7 rounded-3xl border border-[#E8DFD1] bg-white p-5 sm:p-6 shadow-sm">
                    <p class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-[#3D2314]/60">Product description</p>
                    <h2 class="mt-2 text-xl font-heading font-black text-[#3D2314]">About this item</h2>
                    <p class="mt-4 text-sm sm:text-[15px] leading-7 text-gray-700">{{ $product->description }}</p>
                </div>

                <div class="xl:col-span-5 rounded-3xl border border-[#E8DFD1] bg-white p-5 sm:p-6 shadow-sm">
                    <p class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-[#3D2314]/60">Location</p>
                    <h2 class="mt-2 text-xl font-heading font-black text-[#3D2314]">Artisan location</h2>

                    @php
                        $artisanLocation = trim((string) ($product->user->location ?? ''));
                        $artisanLat = $product->user->latitude ?? null;
                        $artisanLng = $product->user->longitude ?? null;

                        if (!empty($artisanLat) && !empty($artisanLng)) {
                            $mapQuery = $artisanLat . ',' . $artisanLng;
                            $mapLabel = $artisanLocation ?: 'Artisan location';
                        } elseif ($artisanLocation !== '') {
                            $mapQuery = $artisanLocation;
                            $mapLabel = $artisanLocation;
                        } else {
                            $mapQuery = 'Tanzania';
                            $mapLabel = 'Tanzania';
                        }
                    @endphp

                    <div class="mt-3 mb-3 rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-[11px] text-amber-900">
                        <strong>Location:</strong> {{ $mapLabel }}
                    </div>

                    <div class="mt-4 overflow-hidden rounded-2xl border border-[#E8DFD1] bg-[#F5F0E8]">
                        <iframe class="w-full h-52 border-0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" src="https://maps.google.com/maps?q={{ urlencode($mapQuery) }}&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
                    </div>

                    <div class="mt-3 flex justify-between items-center text-[11px] text-gray-500">
                        <span>Map view</span>
                        <a href="https://maps.google.com/?q={{ urlencode($mapQuery) }}" target="_blank" class="font-bold text-[#3D2314] hover:underline">Open in Google Maps ↗</a>
                    </div>
                </div>
            </div>
        </section>

        @if(count($artisanProducts ?? []) > 0)
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="mb-4">
                    <span class="text-xs uppercase tracking-widest font-bold text-[#3D2314]/70">More creations</span>
                    <h2 class="text-xl sm:text-2xl font-heading font-black text-[#3D2314]">From this artisan</h2>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($artisanProducts ?? [] as $aProd)
                        <a href="{{ route('products.show', $aProd->id) }}" class="group rounded-2xl bg-white border border-[#E8DFD1] overflow-hidden shadow-sm hover:shadow-md transition duration-300">
                            <div class="aspect-square overflow-hidden bg-[#F5F0E8]">
                                <img src="{{ asset('assets/uploads/' . basename($aProd->image_path ?? $aProd->image)) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" draggable="false" alt="{{ $aProd->title }}">
                            </div>
                            <div class="p-3.5">
                                <p class="font-bold text-[#3D2314] text-sm truncate">{{ $aProd->title }}</p>
                                <p class="mt-0.5 text-xs font-black text-[#3D2314]">TZS {{ number_format($aProd->price) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="rounded-3xl bg-white border border-[#E8DFD1] shadow-sm overflow-hidden">
                <div class="border-b border-gray-100 p-5 sm:p-6">
                    <span class="text-xs uppercase tracking-widest font-bold text-[#3D2314]/70">Customer reviews</span>
                    <h2 class="text-xl sm:text-2xl font-heading font-black text-[#3D2314] mt-0.5">Feedback & reviews</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-5 divide-y lg:divide-y-0 lg:divide-x divide-[#E8DFD1]">
                    <div class="lg:col-span-2 bg-[#FAF7F2] p-5 sm:p-6">
                        <h3 class="text-sm font-bold text-[#3D2314]">Leave a review</h3>
                        <p class="text-xs text-gray-500 mb-4">Share your experience with this product.</p>

                        <form id="reviewForm" class="space-y-3.5">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Your name</label>
                                <input type="text" name="author_name" required class="w-full rounded-xl border-gray-200 bg-white text-sm focus:border-[#3D2314] focus:ring-[#3D2314]">
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Rating</label>
                                <select name="rating" class="w-full rounded-xl border-gray-200 bg-white text-sm focus:border-[#3D2314] focus:ring-[#3D2314]">
                                    <option value="5">⭐⭐⭐⭐⭐ — Excellent</option>
                                    <option value="4">⭐⭐⭐⭐ — Very good</option>
                                    <option value="3">⭐⭐⭐ — Average</option>
                                    <option value="2">⭐⭐ — Fair</option>
                                    <option value="1">⭐ — Poor</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Your review</label>
                                <textarea name="comment" rows="3" required placeholder="Write your review here..." class="w-full rounded-xl border-gray-200 bg-white text-sm focus:border-[#3D2314] focus:ring-[#3D2314]"></textarea>
                            </div>

                            <div id="formAlert" class="hidden p-3 rounded-xl text-xs"></div>

                            <button type="submit" id="submitBtn" class="w-full rounded-xl bg-[#3D2314] hover:bg-[#52301B] py-2.5 text-xs font-bold text-white transition shadow-xs">
                                Submit review
                            </button>
                        </form>
                    </div>

                    <div class="lg:col-span-3 p-5 sm:p-6">
                        <div id="reviewsList" class="space-y-3.5">
                            @forelse($product->reviews ?? [] as $review)
                                <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full bg-[#F5F0E8] flex items-center justify-center font-bold text-xs text-[#3D2314]">
                                                {{ strtoupper(substr($review->author_name ?? $review->reviewer_name ?? 'C', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-sm text-[#3D2314]">{{ $review->author_name ?? $review->reviewer_name ?? 'Customer' }}</p>
                                                <span class="text-[10px] text-gray-400 block">{{ $review->created_at ? $review->created_at->diffForHumans() : '' }}</span>
                                            </div>
                                        </div>
                                        <span class="text-amber-500 text-xs">{{ str_repeat('⭐', $review->rating) }}</span>
                                    </div>
                                    <p class="mt-2.5 text-xs sm:text-sm leading-relaxed text-gray-600">{{ $review->comment }}</p>
                                </div>
                            @empty
                                <div id="noReviewsText" class="flex min-h-[180px] items-center justify-center text-center">
                                    <div>
                                        <div class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-[#F5F0E8] text-lg">💬</div>
                                        <p class="font-bold text-sm text-[#3D2314]">No reviews yet</p>
                                        <p class="mt-0.5 text-xs text-gray-500">Be the first to share your experience.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <script>
        function changeMainImage(imageUrl, button) {
            const viewer = document.getElementById('mainViewer');
            if (!viewer) return;

            viewer.style.opacity = '0.3';
            setTimeout(() => {
                viewer.src = imageUrl;
                viewer.style.opacity = '1';
            }, 100);

            document.querySelectorAll('.gallery-thumb').forEach(btn => {
                btn.classList.remove('border-[#3D2314]');
                btn.classList.add('border-transparent');
            });
            button.classList.remove('border-transparent');
            button.classList.add('border-[#3D2314]');
        }

        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('contextmenu', e => e.preventDefault());
            img.setAttribute('draggable', 'false');
        });

        const reviewForm = document.getElementById('reviewForm');
        if (reviewForm) {
            reviewForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const form = this;
                const submitBtn = document.getElementById('submitBtn');
                const formAlert = document.getElementById('formAlert');
                const formData = new FormData(form);

                submitBtn.disabled = true;
                submitBtn.textContent = 'Sending...';
                formAlert.classList.add('hidden');

                try {
                    const response = await fetch("{{ route('reviews.store') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        formAlert.className = 'p-3 bg-green-50 border border-green-200 rounded-xl text-green-800 text-xs';
                        formAlert.textContent = result.message || 'Review submitted successfully!';
                        formAlert.classList.remove('hidden');

                        form.reset();
                        const noReviewsText = document.getElementById('noReviewsText');
                        if (noReviewsText) noReviewsText.remove();

                        const newReview = result.data;
                        const stars = '⭐'.repeat(newReview.rating || 5);
                        const reviewsList = document.getElementById('reviewsList');
                        const customerName = newReview.customer_name || newReview.author_name || 'Customer';

                        const reviewHtml = `
                            <div class="rounded-xl border border-gray-100 bg-white p-4 animate-pulse">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-[#F5F0E8] flex items-center justify-center font-bold text-xs text-[#3D2314]">
                                            ${customerName.charAt(0).toUpperCase()}
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm text-[#3D2314]">${customerName}</p>
                                            <span class="text-[10px] text-gray-400 block">Just now</span>
                                        </div>
                                    </div>
                                    <span class="text-amber-500 text-xs">${stars}</span>
                                </div>
                                <p class="mt-2.5 text-xs sm:text-sm leading-relaxed text-gray-600">${newReview.comment || ''}</p>
                            </div>
                        `;
                        reviewsList.insertAdjacentHTML('afterbegin', reviewHtml);
                    } else {
                        throw new Error(result.message || 'Failed to submit review.');
                    }
                } catch (error) {
                    formAlert.className = 'p-3 bg-red-50 border border-red-200 rounded-xl text-red-800 text-xs';
                    formAlert.textContent = error.message || 'Something went wrong.';
                    formAlert.classList.remove('hidden');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Submit review';
                }
            });
        }
    </script>
</x-app-layout>
<footer class="bg-[#2C180E] text-amber-100/80 border-t border-amber-900/60 mt-10 pt-10 pb-6 text-xs sm:text-sm font-medium px-3 sm:px-5 lg:px-8 relative overflow-hidden">

    <div class="absolute inset-0 bg-cover bg-center opacity-10 mix-blend-overlay pointer-events-none"
         style="background-image:url('https://images.unsplash.com/photo-1590076215667-875d4ef2d7ee?auto=format&fit=crop&w=1200&q=80');">
    </div>

    <div class="absolute inset-0 opacity-5 pointer-events-none bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-600 via-transparent to-transparent">
        <svg class="w-full h-full text-amber-500 fill-current opacity-20"
             xmlns="http://www.w3.org/2000/svg"
             width="100%"
             height="100%">
            <defs>
                <pattern id="african-pattern"
                         width="60"
                         height="60"
                         patternUnits="userSpaceOnUse">
                    <path d="M30 0 L60 30 L30 60 L0 30 Z M30 10 L50 30 L30 50 L10 30 Z"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="1"/>
                    <circle cx="30"
                            cy="30"
                            r="3"
                            fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100%"
                  height="100%"
                  fill="url(#african-pattern)"/>
        </svg>
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 relative z-10 text-left">

       
        <div class="space-y-4">
            <div class="flex items-center space-x-3">
              
                <img src="{{ asset('assets/images/logo.jpeg') }}" 
                     alt="Asili Yetu Hub Logo" 
                     class="w-12 h-12 sm:w-14 sm:h-14 object-cover rounded-full border border-amber-700/60 shadow-md shrink-0">
               
              
                <span class="text-2xl sm:text-3xl font-artistic tracking-wider text-amber-300">
                    Asili Yetu Hub
                </span>
            </div>

            <p class="text-xs text-amber-200/70 leading-relaxed"
               data-en="Connecting Tanzanian rural artisans, traditional performance groups, and cultural sites directly with global buyers and tourists."
               data-sw="Kuwezesha mafundi wa mikono wa vijijini, vikundi vya ngoma za asili na maeneo ya utalii wa kitamaduni kuunganisha moja kwa moja na wanunuzi na watalii.">
                Connecting Tanzanian rural artisans, traditional performance groups,
                and cultural sites directly with global buyers and tourists.
            </p>

            <div class="flex items-center space-x-3 pt-1">
                <a href="https://www.facebook.com/share/19Y5JdJEf6/"
                   class="w-8 h-8 rounded-full bg-amber-900/60 border border-amber-700/40 flex items-center justify-center text-amber-200 hover:bg-amber-600 hover:text-white transition">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>

                <a href="https://www.instagram.com/johnstone.junior.450229?stkn=cXZnaG9pOTFlazBq"
                   class="w-8 h-8 rounded-full bg-amber-900/60 border border-amber-700/40 flex items-center justify-center text-amber-200 hover:bg-amber-600 hover:text-white transition">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>

                <a href="https://vm.tiktok.com/ZS9ALDKRmSrC8-PQnbu/"
                   class="w-8 h-8 rounded-full bg-amber-900/60 border border-amber-700/40 flex items-center justify-center text-amber-200 hover:bg-amber-600 hover:text-white transition"
                   aria-label="TikTok">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.82.56-1.33 1.52-1.32 2.52-.02.97.47 1.93 1.25 2.5 1.05.78 2.5.83 3.59.13.88-.55 1.42-1.55 1.41-2.59.02-5.46.01-10.93.01-16.39z"/>
                    </svg>
                </a>
            </div>
        </div>

        
        <div class="space-y-2">
            <h3 class="text-amber-300 font-semibold text-xs tracking-wider border-b border-amber-800/50 pb-2 uppercase"
                data-en="Quick Links"
                data-sw="Viungo vya Haraka">
                Quick Links
            </h3>

            <ul class="space-y-1.5 text-xs">
                <li>
                    <a href="{{ url('/') }}"
                       class="hover:text-amber-400 transition"
                       data-en="Home"
                       data-sw="Nyumbani">
                        Home
                    </a>
                </li>
                <li>
                    <a href="#about-section"
                       class="hover:text-amber-400 transition"
                       data-en="About Us"
                       data-sw="Kuhusu Sisi">
                        About Us
                    </a>
                </li>
                <li>
                    <a href="#marketplace-section"
                       class="hover:text-amber-400 transition"
                       data-en="Browse Crafts"
                       data-sw="Vinjari Sanaa na Bidhaa">
                        Browse Crafts
                    </a>
                </li>
            </ul>
        </div>

        
        <div class="space-y-2">
            <h3 class="text-amber-300 font-semibold text-xs tracking-wider border-b border-amber-800/50 pb-2 uppercase"
                data-en="Support & Policy"
                data-sw="Msaada na Sera">
                Support & Policy
            </h3>

            <ul class="space-y-1.5 text-xs">
                <li>
                    <a href="{{ route('shipping') }}"
                       class="hover:text-amber-400 transition"
                       data-en="Shipping & Delivery"
                       data-sw="Usafirishaji na Ufikishaji">
                        Shipping & Delivery
                    </a>
                </li>
                <li>
                    <a href="{{ route('authenticity') }}"
                       class="hover:text-amber-400 transition"
                       data-en="Authenticity Guarantee"
                       data-sw="Uhakika wa Ubora wa Asili">
                        Authenticity Guarantee
                    </a>
                </li>
                <li>
                    <a href="{{ route('privacy') }}"
                       class="hover:text-amber-400 transition"
                       data-en="Privacy Policy"
                       data-sw="Sera ya Faragha">
                        Privacy Policy
                    </a>
                </li>
                <li>
                    <a href="{{ route('terms') }}"
                       class="hover:text-amber-400 transition"
                       data-en="Terms of Service"
                       data-sw="Vigezo na Masharti">
                        Terms of Service
                    </a>
                </li>
            </ul>
        </div>

        <!-- Contact Us -->
        <div class="space-y-2">
            <h3 class="text-amber-300 font-semibold text-xs tracking-wider border-b border-amber-800/50 pb-2 uppercase"
                data-en="Contact Us"
                data-sw="Wasiliana Nasi">
                Contact Us
            </h3>

            <div class="space-y-1.5 text-xs text-amber-200/70">
                <p class="flex items-center space-x-2">
                    <svg class="w-4 h-4 fill-current text-amber-400 shrink-0"
                         viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    <a href="https://maps.google.com/?q=Dar+es+Salaam,+Tanzania"
                       target="_blank"
                       class="hover:text-amber-400 hover:underline transition">
                        Dar es Salaam / Arusha, Tanzania
                    </a>
                </p>

                <p class="flex items-center space-x-2">
                    <span>📞</span>
                    <span>+255 700 000 000</span>
                </p>

                <p class="flex items-center space-x-2">
                    <span>✉️</span>
                    <span>info@asiliyetuhub.co.tz</span>
                </p>
            </div>
        </div>

    </div>

    <div class="max-w-7xl mx-auto border-t border-amber-900/60 pt-5 flex flex-col sm:flex-row justify-between items-center text-xs text-amber-200/60 gap-3 relative z-10">
        <p>
            &copy; {{ date('Y') }} Asili Yetu Hub.
            <span data-en="Empowering Tanzanian Artisans & Cultural Tourism."
                  data-sw="Kuwezesha Wasanii wa Kitanzania na Utalii wa Kitamaduni.">
                Empowering Tanzanian Artisans & Cultural Tourism.
            </span>
        </p>
    </div>

</footer>
                
