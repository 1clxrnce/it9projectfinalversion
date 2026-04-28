<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Browse Products - {{ config('app.name') }}</title>
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
                    <a href="{{ route('home') }}" class="text-gray-300 hover:text-red-500 font-medium transition">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Home
                    </a>
                    @auth
                        @if(Auth::user()->isAdmin() || Auth::user()->isStaff())
                            <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-2.5 rounded-xl hover:from-red-700 hover:to-red-800 font-semibold shadow-lg shadow-red-500/30 transition-all duration-200">
                                Dashboard
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">Browse Products</h1>
                <p class="text-gray-400">Explore our collection of premium computer components</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
                {{-- Sidebar Filters --}}
                <aside class="w-full lg:w-80 shrink-0 space-y-6">
                    {{-- Search --}}
                    <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6">
                        <label class="text-xs font-bold text-gray-300 uppercase tracking-wider mb-4 block flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search Products
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   id="searchInput"
                                   placeholder="Search by name..." 
                                   class="w-full pl-11 pr-4 py-3.5 bg-gray-700 border border-gray-600 rounded-xl text-sm text-white placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    {{-- Price Range --}}
                    <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6">
                        <label class="text-xs font-bold text-gray-300 uppercase tracking-wider mb-4 block flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            Price Range
                        </label>
                        <div class="space-y-4">
                            <div class="flex justify-between text-sm font-semibold text-white">
                                <span>₱<span id="minPriceDisplay">0</span></span>
                                <span>₱<span id="maxPriceDisplay">200,000</span></span>
                            </div>
                            <div class="space-y-3">
                                <input type="range" id="minPriceSlider" min="0" max="200000" step="1000" value="0" class="w-full h-2 bg-gray-600 rounded-lg appearance-none cursor-pointer accent-red-500">
                                <input type="range" id="maxPriceSlider" min="0" max="200000" step="1000" value="200000" class="w-full h-2 bg-gray-600 rounded-lg appearance-none cursor-pointer accent-red-600">
                            </div>
                        </div>
                    </div>

                    {{-- Categories --}}
                    <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6">
                        <label class="text-xs font-bold text-gray-300 uppercase tracking-wider mb-4 block flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Categories
                        </label>
                        <div class="flex flex-wrap gap-2">
                            <button data-category="all" class="category-chip px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ !request('category') ? 'bg-red-600 text-white shadow-lg shadow-red-500/30' : 'bg-gray-700 text-gray-300 border border-gray-600 hover:border-red-500 hover:text-red-400' }}">
                                All Categories
                            </button>
                            @foreach($categories as $category)
                            <button data-category="{{ $category->category_id }}" class="category-chip px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request('category') == $category->category_id ? 'bg-red-600 text-white shadow-lg shadow-red-500/30' : 'bg-gray-700 text-gray-300 border border-gray-600 hover:border-red-500 hover:text-red-400' }}">
                                {{ $category->category_name }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Brands --}}
                    <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6">
                        <label class="text-xs font-bold text-gray-300 uppercase tracking-wider mb-4 block flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Brands
                        </label>
                        <div class="flex flex-wrap gap-2">
                            <button data-brand="all" class="brand-chip px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ !request('brand') ? 'bg-red-600 text-white shadow-lg shadow-red-500/30' : 'bg-gray-700 text-gray-300 border border-gray-600 hover:border-red-500 hover:text-red-400' }}">
                                All Brands
                            </button>
                            @foreach($brands as $brand)
                            <button data-brand="{{ $brand->brand_id }}" class="brand-chip px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request('brand') == $brand->brand_id ? 'bg-red-600 text-white shadow-lg shadow-red-500/30' : 'bg-gray-700 text-gray-300 border border-gray-600 hover:border-red-500 hover:text-red-400' }}">
                                {{ $brand->brand_name }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </aside>

                {{-- Main Content --}}
                <main class="flex-1 space-y-6 min-w-0">
                    {{-- Header Bar --}}
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gray-800 rounded-2xl border border-gray-700 px-6 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Showing Products</p>
                                <p class="text-xl font-bold text-white"><span id="visibleCount">{{ $products->count() }}</span> <span class="text-gray-500 font-normal text-lg">of {{ $products->total() }}</span></p>
                            </div>
                        </div>
                        <select id="sortSelect" class="w-full sm:w-auto min-w-[220px] px-4 py-3 border border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-700 text-white font-medium shadow-sm">
                            <option value="name-asc">Name: A → Z</option>
                            <option value="name-desc">Name: Z → A</option>
                            <option value="price-asc">Price: Low → High</option>
                            <option value="price-desc">Price: High → Low</option>
                            <option value="stock-asc">Stock: Low → High</option>
                            <option value="stock-desc">Stock: High → Low</option>
                        </select>
                    </div>

                    @if($products->count() > 0)
                        <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($products as $product)
                            <div class="product-card group bg-gray-800 rounded-2xl border border-gray-700 hover:border-red-500 hover:shadow-xl hover:shadow-red-900/50 transition-all duration-300 overflow-hidden"
                                 data-name="{{ strtolower($product->product_name) }}"
                                 data-price="{{ $product->price }}"
                                 data-stock="{{ $product->inventory ? $product->inventory->quantity : 0 }}"
                                 data-category="{{ $product->category_id }}"
                                 data-brand="{{ $product->brand_id }}">
                                {{-- Product Image --}}
                                <div class="relative bg-gradient-to-br from-gray-700 to-gray-800 h-56 flex items-center justify-center p-6">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->product_name }}" 
                                             class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="text-gray-600">
                                            <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    {{-- Stock Badge --}}
                                    <div class="absolute top-4 left-4">
                                        @php
                                            $quantity = $product->inventory ? $product->inventory->quantity : 0;
                                        @endphp
                                        
                                        @if($quantity >= 21)
                                            <span class="backdrop-blur-md bg-emerald-500/90 text-white text-xs px-3 py-1.5 rounded-full font-semibold shadow-lg flex items-center gap-1.5">
                                                <span class="w-2 h-2 bg-white rounded-full"></span>
                                                {{ $quantity }} in stock
                                            </span>
                                        @elseif($quantity >= 11)
                                            <span class="backdrop-blur-md bg-yellow-500/90 text-white text-xs px-3 py-1.5 rounded-full font-semibold shadow-lg flex items-center gap-1.5">
                                                <span class="w-2 h-2 bg-white rounded-full"></span>
                                                {{ $quantity }} in stock
                                            </span>
                                        @elseif($quantity >= 1)
                                            <span class="backdrop-blur-md bg-rose-500/90 text-white text-xs px-3 py-1.5 rounded-full font-semibold shadow-lg flex items-center gap-1.5">
                                                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                                Low Stock: {{ $quantity }}
                                            </span>
                                        @else
                                            <span class="backdrop-blur-md bg-gray-900/90 text-white text-xs px-3 py-1.5 rounded-full font-semibold shadow-lg flex items-center gap-1.5">
                                                <span class="w-2 h-2 bg-white rounded-full"></span>
                                                Out of stock
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Product Info --}}
                                <div class="p-6">
                                    <div class="flex items-center gap-2 mb-3 flex-wrap">
                                        <span class="text-xs text-gray-400 bg-gray-700 px-3 py-1.5 rounded-lg font-medium">{{ $product->category->category_name }}</span>
                                        <span class="text-xs text-red-400 bg-red-900/30 px-3 py-1.5 rounded-lg font-semibold">{{ $product->brand ? $product->brand->brand_name : 'No Brand' }}</span>
                                    </div>

                                    <h3 class="font-bold text-white mb-2 line-clamp-2 min-h-[3rem] group-hover:text-red-400 transition" title="{{ $product->product_name }}">
                                        {{ $product->product_name }}
                                    </h3>

                                    @if($product->description)
                                    <p class="text-sm text-gray-400 mb-4 line-clamp-2 leading-relaxed">
                                        {{ $product->description }}
                                    </p>
                                    @endif

                                    <div class="pt-4 border-t border-gray-700">
                                        <span class="text-2xl font-bold text-white">₱{{ number_format($product->price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-8">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="bg-gray-800 rounded-2xl border border-gray-700 p-12 text-center">
                            <svg class="w-20 h-20 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <h3 class="text-xl font-bold text-white mb-2">No products found</h3>
                            <p class="text-gray-400 mb-6">Try adjusting your filters or search terms</p>
                            <a href="{{ route('products.index') }}" class="inline-block bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-3 rounded-xl hover:from-red-700 hover:to-red-800 font-semibold shadow-lg shadow-red-500/30 transition-all duration-200">
                                View All Products
                            </a>
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedCategory = '{{ request("category") ?? "all" }}';
            let selectedBrand = '{{ request("brand") ?? "all" }}';

            // Price sliders
            const minPriceSlider = document.getElementById('minPriceSlider');
            const maxPriceSlider = document.getElementById('maxPriceSlider');
            const minPriceDisplay = document.getElementById('minPriceDisplay');
            const maxPriceDisplay = document.getElementById('maxPriceDisplay');

            function updatePriceDisplay() {
                const minPrice = parseInt(minPriceSlider.value);
                const maxPrice = parseInt(maxPriceSlider.value);
                
                minPriceDisplay.textContent = minPrice.toLocaleString();
                maxPriceDisplay.textContent = maxPrice.toLocaleString();
                
                filterProducts();
            }

            minPriceSlider.addEventListener('input', updatePriceDisplay);
            maxPriceSlider.addEventListener('input', updatePriceDisplay);

            // Search functionality
            document.getElementById('searchInput').addEventListener('input', filterProducts);

            // Category chips
            document.querySelectorAll('.category-chip').forEach(chip => {
                chip.addEventListener('click', function() {
                    const category = this.dataset.category;
                    selectedCategory = category;
                    
                    // Update active state
                    document.querySelectorAll('.category-chip').forEach(c => {
                        c.classList.remove('bg-red-600', 'text-white', 'shadow-lg', 'shadow-red-500/30');
                        c.classList.add('bg-gray-700', 'text-gray-300', 'border', 'border-gray-600');
                    });
                    this.classList.remove('bg-gray-700', 'text-gray-300', 'border', 'border-gray-600');
                    this.classList.add('bg-red-600', 'text-white', 'shadow-lg', 'shadow-red-500/30');
                    
                    filterProducts();
                });
            });

            // Brand chips
            document.querySelectorAll('.brand-chip').forEach(chip => {
                chip.addEventListener('click', function() {
                    const brand = this.dataset.brand;
                    selectedBrand = brand;
                    
                    // Update active state
                    document.querySelectorAll('.brand-chip').forEach(c => {
                        c.classList.remove('bg-red-600', 'text-white', 'shadow-lg', 'shadow-red-500/30');
                        c.classList.add('bg-gray-700', 'text-gray-300', 'border', 'border-gray-600');
                    });
                    this.classList.remove('bg-gray-700', 'text-gray-300', 'border', 'border-gray-600');
                    this.classList.add('bg-red-600', 'text-white', 'shadow-lg', 'shadow-red-500/30');
                    
                    filterProducts();
                });
            });

            // Sort functionality
            document.getElementById('sortSelect').addEventListener('change', sortProducts);

            function filterProducts() {
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                const minPrice = parseInt(minPriceSlider.value);
                const maxPrice = parseInt(maxPriceSlider.value);
                const cards = document.querySelectorAll('.product-card');
                let count = 0;

                cards.forEach(card => {
                    const name = card.dataset.name;
                    const price = parseFloat(card.dataset.price);
                    const category = card.dataset.category;
                    const brand = card.dataset.brand;
                    
                    const matchesSearch = name.includes(searchTerm);
                    const matchesPrice = price >= minPrice && price <= maxPrice;
                    const matchesCategory = selectedCategory === 'all' || category === selectedCategory;
                    const matchesBrand = selectedBrand === 'all' || brand === selectedBrand;

                    if (matchesSearch && matchesPrice && matchesCategory && matchesBrand) {
                        card.style.display = 'block';
                        count++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                document.getElementById('visibleCount').textContent = count;
            }

            function sortProducts() {
                const sortValue = this.value;
                const grid = document.getElementById('productsGrid');
                const cards = Array.from(document.querySelectorAll('.product-card'));

                cards.sort((a, b) => {
                    switch(sortValue) {
                        case 'name-asc':
                            return a.dataset.name.localeCompare(b.dataset.name);
                        case 'name-desc':
                            return b.dataset.name.localeCompare(a.dataset.name);
                        case 'price-asc':
                            return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                        case 'price-desc':
                            return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                        case 'stock-asc':
                            return parseInt(a.dataset.stock) - parseInt(b.dataset.stock);
                        case 'stock-desc':
                            return parseInt(b.dataset.stock) - parseInt(a.dataset.stock);
                        default:
                            return 0;
                    }
                });

                cards.forEach(card => grid.appendChild(card));
            }
        });
    </script>
</body>
</html>
