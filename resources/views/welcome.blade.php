<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Computer Parts & Components Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 antialiased text-white">
    {{-- Navigation --}}
    <nav class="bg-gray-900/95 backdrop-blur-md border-b border-gray-800 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg overflow-hidden">
                        <img src="{{ asset('storage/logo/logo.png') }}" alt="{{ config('app.name') }} Logo" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">{{ config('app.name') }}</span>
                        <p class="text-xs text-gray-400 font-medium">Computer Parts & Components</p>
                    </div>
                </a>
                
                <div class="flex items-center gap-4">
                    @auth
                        @if(Auth::user()->isAdmin() || Auth::user()->isStaff())
                            <a href="{{ url('/dashboard') }}" class="hidden sm:flex items-center gap-2 text-gray-300 hover:text-red-500 font-medium transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Dashboard
                            </a>
                        @else
                            {{-- Customer Menu --}}
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center gap-2 text-gray-300 hover:text-red-500 font-medium transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="hidden sm:inline">{{ Auth::user()->firstName }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-xl shadow-xl border border-gray-700 py-2 z-50">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-red-900/50 hover:text-red-400 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Profile
                                    </a>
                                    <hr class="my-2 border-gray-700">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-400 hover:bg-red-900/50 transition text-left">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-red-500 font-medium transition">Sign In</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-2.5 rounded-xl hover:from-red-700 hover:to-red-800 font-semibold shadow-lg shadow-red-500/30 transition-all duration-200 hover:shadow-xl hover:shadow-red-500/40">
                                Get Started
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Carousel Section --}}
    <section class="relative bg-gray-900 overflow-hidden">
        <div class="carousel-container relative h-[500px] md:h-[600px] lg:h-[700px]">
            {{-- Carousel Slides --}}
            <div class="carousel-slides relative w-full h-full">
                {{-- Slide 1 --}}
                <div class="carousel-slide absolute inset-0 opacity-100 transition-opacity duration-1000">
                    <img src="{{ asset('storage/dekstop/670862125_1488677959937361_431219952873626822_n.jpg') }}" alt="Slide 1" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                </div>

                {{-- Slide 2 --}}
                <div class="carousel-slide absolute inset-0 opacity-0 transition-opacity duration-1000">
                    <img src="{{ asset('storage/dekstop/d6cfe5de-7a67-4c77-b665-35420c0238d8.jpg') }}" alt="Slide 2" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                </div>

                {{-- Slide 3 --}}
                <div class="carousel-slide absolute inset-0 opacity-0 transition-opacity duration-1000">
                    <img src="{{ asset('storage/dekstop/d065a61e-9733-462b-a524-42238f574c05.jpg') }}" alt="Slide 3" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                </div>
            </div>

            {{-- Navigation Arrows --}}
            <button class="carousel-prev absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white/20 backdrop-blur-sm hover:bg-white/30 rounded-full flex items-center justify-center transition-all duration-200 group">
                <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button class="carousel-next absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white/20 backdrop-blur-sm hover:bg-white/30 rounded-full flex items-center justify-center transition-all duration-200 group">
                <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            {{-- Dots Navigation --}}
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex gap-3">
                <button class="carousel-dot w-3 h-3 rounded-full bg-white transition-all duration-300" data-slide="0"></button>
                <button class="carousel-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white/75 transition-all duration-300" data-slide="1"></button>
                <button class="carousel-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white/75 transition-all duration-300" data-slide="2"></button>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.carousel-slide');
            const dots = document.querySelectorAll('.carousel-dot');
            const prevBtn = document.querySelector('.carousel-prev');
            const nextBtn = document.querySelector('.carousel-next');
            let currentSlide = 0;
            let autoplayInterval;

            function showSlide(index) {
                // Hide all slides
                slides.forEach(slide => {
                    slide.classList.remove('opacity-100');
                    slide.classList.add('opacity-0');
                });

                // Update dots
                dots.forEach(dot => {
                    dot.classList.remove('bg-white', 'w-8');
                    dot.classList.add('bg-white/50', 'w-3');
                });

                // Show current slide
                slides[index].classList.remove('opacity-0');
                slides[index].classList.add('opacity-100');

                // Highlight current dot
                dots[index].classList.remove('bg-white/50', 'w-3');
                dots[index].classList.add('bg-white', 'w-8');

                currentSlide = index;
            }

            function nextSlide() {
                const next = (currentSlide + 1) % slides.length;
                showSlide(next);
            }

            function prevSlide() {
                const prev = (currentSlide - 1 + slides.length) % slides.length;
                showSlide(prev);
            }

            function startAutoplay() {
                autoplayInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
            }

            function stopAutoplay() {
                clearInterval(autoplayInterval);
            }

            // Event listeners
            nextBtn.addEventListener('click', () => {
                nextSlide();
                stopAutoplay();
                startAutoplay();
            });

            prevBtn.addEventListener('click', () => {
                prevSlide();
                stopAutoplay();
                startAutoplay();
            });

            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    showSlide(index);
                    stopAutoplay();
                    startAutoplay();
                });
            });

            // Pause on hover
            const carouselContainer = document.querySelector('.carousel-container');
            carouselContainer.addEventListener('mouseenter', stopAutoplay);
            carouselContainer.addEventListener('mouseleave', startAutoplay);

            // Start autoplay
            startAutoplay();
        });
    </script>

    {{-- Partner Brands --}}
    <section class="py-16 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-2">Trusted Partner Brands</h2>
                <p class="text-sm text-gray-400">We work with the industry's leading manufacturers</p>
            </div>
            
            <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($brands as $brand)
                <a href="{{ route('products.index', ['brand' => $brand->brand_id]) }}" class="group bg-gray-800 border border-gray-700 rounded-xl p-4 flex flex-col items-center justify-center hover:border-red-500 hover:bg-gray-750 transition-all duration-200 aspect-square">
                    @if($brand->image)
                        <img src="{{ asset('storage/' . $brand->image) }}" 
                             alt="{{ $brand->brand_name }}" 
                             class="max-h-12 max-w-full object-contain group-hover:scale-105 transition-transform duration-200 mb-2">
                    @endif
                    
                    <span class="text-sm font-semibold text-gray-400 group-hover:text-white transition-colors text-center">{{ $brand->brand_name }}</span>
                    
                    <span class="text-xs text-gray-500 mt-1">{{ $brand->products->count() }} Products</span>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Browse Categories --}}
    <section id="categories" class="py-20 bg-gradient-to-br from-gray-800 to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-3">Browse by Category</h2>
                <div class="h-1 w-24 bg-gradient-to-r from-red-500 to-red-600 rounded-full mx-auto mb-3"></div>
                <p class="text-base text-gray-400">Find exactly what you need for your perfect build</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($categories as $category)
                @php
                    $categoryIcons = [
                        'CPU' => ['icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z', 'color' => 'from-blue-500 to-cyan-500'],
                        'GPU' => ['icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01', 'color' => 'from-green-500 to-emerald-500'],
                        'RAM' => ['icon' => 'M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01', 'color' => 'from-purple-500 to-pink-500'],
                        'Motherboard' => ['icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z', 'color' => 'from-orange-500 to-red-500'],
                        'Storage' => ['icon' => 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4', 'color' => 'from-indigo-500 to-blue-500'],
                        'Power Supply' => ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'color' => 'from-yellow-500 to-orange-500'],
                        'Case' => ['icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z', 'color' => 'from-gray-500 to-slate-500'],
                        'Cooling' => ['icon' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z', 'color' => 'from-cyan-500 to-blue-500'],
                    ];
                    
                    $catName = $category->category_name;
                    $catData = $categoryIcons[$catName] ?? ['icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10', 'color' => 'from-gray-500 to-gray-700'];
                @endphp
                
                <a href="{{ route('products.index', ['category' => $category->category_id]) }}" class="group relative bg-gray-800 rounded-2xl overflow-hidden hover:shadow-xl hover:shadow-red-500/20 transition-all duration-300 cursor-pointer border-2 border-gray-700 hover:border-red-500">
                    {{-- Gradient Background --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-red-600 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                    
                    {{-- Image Section --}}
                    <div class="relative h-40 bg-gradient-to-br {{ $catData['color'] }} flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-black/20"></div>
                        
                        @if($category->image && file_exists(public_path('storage/' . $category->image)))
                            {{-- Category Image --}}
                            <img src="{{ asset('storage/' . $category->image) }}" 
                                 alt="{{ $category->category_name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            {{-- Fallback Icon --}}
                            <svg class="w-20 h-20 text-white opacity-90 group-hover:scale-110 transition-transform duration-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $catData['icon'] }}"></path>
                            </svg>
                        @endif
                        
                        {{-- Product Count Badge --}}
                        <div class="absolute top-3 right-3 bg-gray-900/90 backdrop-blur-sm px-2.5 py-1 rounded-full z-10">
                            <span class="text-xs font-bold text-white">{{ $category->products_count }} Items</span>
                        </div>
                    </div>
                    
                    {{-- Content Section --}}
                    <div class="relative p-5">
                        <h3 class="text-lg font-bold text-white mb-1 group-hover:text-red-400 transition-colors">{{ $category->category_name }}</h3>
                        <p class="text-sm text-gray-400 mb-3">Explore our collection</p>
                        <div class="flex items-center text-red-500 font-semibold text-sm group-hover:gap-2 gap-1 transition-all">
                            <span>Explore</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            {{-- CTA Section --}}
            <div class="mt-16 text-center">
                <div class="inline-block bg-gray-800 rounded-2xl border-2 border-gray-700 p-8 shadow-lg hover:shadow-xl hover:shadow-red-500/20 transition-shadow duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-red-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Need Help Choosing?</h3>
                    <p class="text-gray-400 mb-6 max-w-md mx-auto">Our expert team can help you find the perfect components for your build</p>
                    @auth
                        @if(Auth::user()->isCustomer())
                            <a href="#categories" class="inline-flex items-center gap-2 bg-gradient-to-r from-red-600 to-red-700 text-white px-8 py-3 rounded-xl hover:from-red-700 hover:to-red-800 font-semibold shadow-xl shadow-red-500/30 transition-all duration-200 hover:shadow-2xl hover:shadow-red-500/40 hover:-translate-y-0.5">
                                Browse All Products
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-red-600 to-red-700 text-white px-8 py-3 rounded-xl hover:from-red-700 hover:to-red-800 font-semibold shadow-xl shadow-red-500/30 transition-all duration-200 hover:shadow-2xl hover:shadow-red-500/40 hover:-translate-y-0.5">
                                View All Products
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-red-600 to-red-700 text-white px-8 py-3 rounded-xl hover:from-red-700 hover:to-red-800 font-semibold shadow-xl shadow-red-500/30 transition-all duration-200 hover:shadow-2xl hover:shadow-red-500/40 hover:-translate-y-0.5">
                            Create Account
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold">{{ config('app.name') }}</span>
                    </div>
                    <p class="text-gray-400 text-sm mb-4">BJ Computers - Your trusted partner for quality computer parts and components. Building better PCs, one component at a time.</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-red-600 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-red-600 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-red-600 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="font-semibold text-white mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Contact Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Support Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Warranty Info</a></li>
                    </ul>
                </div>

                {{-- Contact Info --}}
                <div>
                    <h4 class="font-semibold text-white mb-4">Contact Info</h4>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-start gap-2 text-gray-400">
                            <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>123 Tech Street, Silicon Valley, CA 94000</span>
                        </li>
                        <li class="flex items-center gap-2 text-gray-400">
                            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>support@example.com</span>
                        </li>
                        <li class="flex items-center gap-2 text-gray-400">
                            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>+1 (555) 123-4567</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Bottom Bar --}}
            <div class="border-t border-gray-800 pt-6">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-3 text-sm text-gray-400">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                    <div class="flex gap-4">
                        <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                        <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                        <a href="#" class="hover:text-white transition-colors">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
