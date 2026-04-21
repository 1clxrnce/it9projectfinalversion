<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">Products</h2>
                <p class="text-sm text-gray-500 mt-1">Manage your product inventory</p>
            </div>
            <div class="flex gap-3 w-full sm:w-auto">
                <a href="{{ route('admin.products.archived') }}" class="bg-slate-600 text-white px-6 py-3 rounded-xl hover:bg-slate-700 font-medium shadow-lg transition-all duration-200 flex-1 sm:flex-initial text-center">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        Archive
                    </span>
                </a>
                <a href="{{ route('admin.products.create') }}" class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-6 py-3 rounded-xl hover:from-indigo-700 hover:to-violet-700 font-medium shadow-lg shadow-indigo-500/30 transition-all duration-200 hover:shadow-xl hover:shadow-indigo-500/40 flex-1 sm:flex-initial text-center">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Product
                    </span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-white border-l-4 border-emerald-500 text-emerald-700 px-6 py-4 rounded-xl mb-6 shadow-sm flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
                {{-- Seamless Sidebar Filters --}}
                <aside class="w-full lg:w-80 shrink-0 space-y-6">
                    {{-- Search --}}
                    <div>
                        <label class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-3 block">Search</label>
                        <div class="relative">
                            <input type="text" 
                                   id="searchInput"
                                   placeholder="Search products..." 
                                   class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm">
                            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    {{-- Price Range Slider --}}
                    <div>
                        <label class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-3 block">Price Range</label>
                        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                            <div class="flex justify-between mb-4">
                                <span class="text-sm font-semibold text-gray-900">₱<span id="minPriceDisplay">0</span></span>
                                <span class="text-sm font-semibold text-gray-900">₱<span id="maxPriceDisplay">200,000</span></span>
                            </div>
                            <div class="space-y-3">
                                <input type="range" id="minPriceSlider" min="0" max="200000" step="1000" value="0" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                <input type="range" id="maxPriceSlider" min="0" max="200000" step="1000" value="200000" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-violet-600">
                            </div>
                        </div>
                    </div>

                    {{-- Categories with Toggle Chips --}}
                    <div>
                        <label class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-3 block">Categories</label>
                        <div class="flex flex-wrap gap-2">
                            <button data-category="all" class="category-chip px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-indigo-600 text-white shadow-lg shadow-indigo-500/30">
                                All
                            </button>
                            @foreach($categories as $category)
                            <button data-category="{{ $category->category_id }}" class="category-chip px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white text-gray-700 border border-slate-200 hover:border-indigo-300">
                                {{ $category->category_name }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Brands with Toggle Chips --}}
                    <div>
                        <label class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-3 block">Brands</label>
                        <div class="flex flex-wrap gap-2">
                            <button data-brand="all" class="brand-chip px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-indigo-600 text-white shadow-lg shadow-indigo-500/30">
                                All
                            </button>
                            @foreach($brands as $brand)
                            <button data-brand="{{ $brand->brand_id }}" class="brand-chip px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white text-gray-700 border border-slate-200 hover:border-indigo-300">
                                {{ $brand->brand_name }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </aside>

                {{-- Main Content --}}
                <main class="flex-1 space-y-6 min-w-0">
                    {{-- Header Bar --}}
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white rounded-xl shadow-sm border border-slate-200 px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-violet-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Showing</p>
                                <p class="text-lg font-bold text-gray-900"><span id="visibleCount">{{ $products->count() }}</span> <span class="text-gray-400 font-normal">of {{ $products->count() }}</span></p>
                            </div>
                        </div>
                        <select id="sortSelect" class="w-full sm:w-auto min-w-[200px] px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white font-medium text-gray-700 shadow-sm appearance-none bg-no-repeat bg-right pr-10" style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-size: 1.5em; background-position: right 0.5rem center;">
                            <option value="name-asc">Name: A → Z</option>
                            <option value="name-desc">Name: Z → A</option>
                            <option value="price-asc">Price: Low → High</option>
                            <option value="price-desc">Price: High → Low</option>
                            <option value="stock-asc">Stock: Low → High</option>
                            <option value="stock-desc">Stock: High → Low</option>
                        </select>
                    </div>

                    {{-- Stock Status Legend --}}
                    <div class="bg-gradient-to-r from-indigo-50 to-violet-50 rounded-xl border border-indigo-100 px-6 py-4">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-xs font-bold text-indigo-900 uppercase tracking-wider">Stock Status Guide</span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 bg-emerald-500 rounded-full flex-shrink-0"></span>
                                <span class="text-xs text-gray-700"><span class="font-semibold">High:</span> 21+</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 bg-yellow-500 rounded-full flex-shrink-0"></span>
                                <span class="text-xs text-gray-700"><span class="font-semibold">Medium:</span> 11-20</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 bg-rose-500 rounded-full flex-shrink-0 animate-pulse"></span>
                                <span class="text-xs text-gray-700"><span class="font-semibold">Low:</span> 1-10</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 bg-gray-900 rounded-full flex-shrink-0"></span>
                                <span class="text-xs text-gray-700"><span class="font-semibold">Out:</span> 0</span>
                            </div>
                        </div>
                    </div>

                    {{-- Products Grid --}}
                    <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($products as $product)
                        <div class="product-card group bg-white rounded-2xl border border-slate-200 hover:border-indigo-300 hover:shadow-xl transition-all duration-300 overflow-hidden"
                             data-name="{{ strtolower($product->product_name) }}"
                             data-price="{{ $product->price }}"
                             data-stock="{{ $product->inventory ? $product->inventory->quantity : 0 }}"
                             data-category="{{ $product->category_id }}"
                             data-brand="{{ $product->brand_id }}">
                            
                            {{-- Product Image --}}
                            <div class="relative bg-gradient-to-br from-slate-50 to-slate-100 h-64 flex items-center justify-center p-6 overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->product_name }}" 
                                         class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="text-slate-300">
                                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Floating Stock Badge --}}
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

                                {{-- Three Dot Menu --}}
                                <div class="absolute top-4 right-4 dropdown-container">
                                    <button class="dropdown-toggle w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition shadow-lg">
                                        <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-200 py-2 z-10">
                                        <a href="{{ route('admin.products.edit', $product->product_id) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit Product
                                        </a>
                                        <a href="{{ route('transactions.create') }}?product={{ $product->product_id }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Add Stock
                                        </a>
                                        <hr class="my-2 border-slate-200">
                                        <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Move this product to archive?')" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 transition text-left">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                </svg>
                                                Archive Product
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Product Info --}}
                            <div class="p-6">
                                {{-- Category & Brand Pills --}}
                                <div class="flex items-center gap-2 mb-3 flex-wrap">
                                    <span class="text-xs text-slate-600 bg-slate-100 px-2.5 py-1 rounded-lg font-medium">{{ $product->category->category_name }}</span>
                                    <span class="text-xs text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg font-semibold">{{ $product->brand->brand_name }}</span>
                                </div>

                                {{-- Product Name --}}
                                <h3 class="font-bold text-gray-900 mb-2 line-clamp-2 min-h-[3.5rem] text-lg group-hover:text-indigo-600 transition" title="{{ $product->product_name }}">
                                    {{ $product->product_name }}
                                </h3>

                                {{-- Description --}}
                                @if($product->description)
                                <p class="text-sm text-slate-600 mb-4 line-clamp-2 leading-relaxed">
                                    {{ $product->description }}
                                </p>
                                @endif

                                {{-- Price --}}
                                <div class="pt-4 border-t border-slate-100">
                                    <span class="text-2xl sm:text-3xl font-bold text-gray-900">₱{{ number_format($product->price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </main>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedCategories = ['all'];
            let selectedBrands = ['all'];
            let minPrice = 0;
            let maxPrice = 200000;

            // Search functionality
            document.getElementById('searchInput').addEventListener('input', filterProducts);

            // Price sliders
            const minSlider = document.getElementById('minPriceSlider');
            const maxSlider = document.getElementById('maxPriceSlider');
            
            minSlider.addEventListener('input', function() {
                minPrice = parseInt(this.value);
                document.getElementById('minPriceDisplay').textContent = minPrice.toLocaleString();
                filterProducts();
            });
            
            maxSlider.addEventListener('input', function() {
                maxPrice = parseInt(this.value);
                document.getElementById('maxPriceDisplay').textContent = maxPrice.toLocaleString();
                filterProducts();
            });

            // Category chips
            document.querySelectorAll('.category-chip').forEach(chip => {
                chip.addEventListener('click', function() {
                    const category = this.dataset.category;
                    
                    if (category === 'all') {
                        selectedCategories = ['all'];
                        document.querySelectorAll('.category-chip').forEach(c => {
                            c.classList.remove('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/30');
                            c.classList.add('bg-white', 'text-gray-700', 'border', 'border-slate-200');
                        });
                        this.classList.add('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/30');
                        this.classList.remove('bg-white', 'text-gray-700', 'border', 'border-slate-200');
                    } else {
                        const allChip = document.querySelector('.category-chip[data-category="all"]');
                        allChip.classList.remove('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/30');
                        allChip.classList.add('bg-white', 'text-gray-700', 'border', 'border-slate-200');
                        
                        const index = selectedCategories.indexOf('all');
                        if (index > -1) selectedCategories.splice(index, 1);
                        
                        const catIndex = selectedCategories.indexOf(category);
                        if (catIndex > -1) {
                            selectedCategories.splice(catIndex, 1);
                            this.classList.remove('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/30');
                            this.classList.add('bg-white', 'text-gray-700', 'border', 'border-slate-200');
                        } else {
                            selectedCategories.push(category);
                            this.classList.add('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/30');
                            this.classList.remove('bg-white', 'text-gray-700', 'border', 'border-slate-200');
                        }
                        
                        if (selectedCategories.length === 0) {
                            selectedCategories = ['all'];
                            allChip.classList.add('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/30');
                            allChip.classList.remove('bg-white', 'text-gray-700', 'border', 'border-slate-200');
                        }
                    }
                    filterProducts();
                });
            });

            // Brand chips
            document.querySelectorAll('.brand-chip').forEach(chip => {
                chip.addEventListener('click', function() {
                    const brand = this.dataset.brand;
                    
                    if (brand === 'all') {
                        selectedBrands = ['all'];
                        document.querySelectorAll('.brand-chip').forEach(c => {
                            c.classList.remove('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/30');
                            c.classList.add('bg-white', 'text-gray-700', 'border', 'border-slate-200');
                        });
                        this.classList.add('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/30');
                        this.classList.remove('bg-white', 'text-gray-700', 'border', 'border-slate-200');
                    } else {
                        const allChip = document.querySelector('.brand-chip[data-brand="all"]');
                        allChip.classList.remove('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/30');
                        allChip.classList.add('bg-white', 'text-gray-700', 'border', 'border-slate-200');
                        
                        const index = selectedBrands.indexOf('all');
                        if (index > -1) selectedBrands.splice(index, 1);
                        
                        const brandIndex = selectedBrands.indexOf(brand);
                        if (brandIndex > -1) {
                            selectedBrands.splice(brandIndex, 1);
                            this.classList.remove('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/30');
                            this.classList.add('bg-white', 'text-gray-700', 'border', 'border-slate-200');
                        } else {
                            selectedBrands.push(brand);
                            this.classList.add('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/30');
                            this.classList.remove('bg-white', 'text-gray-700', 'border', 'border-slate-200');
                        }
                        
                        if (selectedBrands.length === 0) {
                            selectedBrands = ['all'];
                            allChip.classList.add('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/30');
                            allChip.classList.remove('bg-white', 'text-gray-700', 'border', 'border-slate-200');
                        }
                    }
                    filterProducts();
                });
            });

            // Sort functionality
            document.getElementById('sortSelect').addEventListener('change', sortProducts);

            // Dropdown menus
            document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const menu = this.nextElementSibling;
                    document.querySelectorAll('.dropdown-menu').forEach(m => {
                        if (m !== menu) m.classList.add('hidden');
                    });
                    menu.classList.toggle('hidden');
                });
            });

            document.addEventListener('click', function() {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.add('hidden');
                });
            });

            function filterProducts() {
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                const cards = document.querySelectorAll('.product-card');
                let count = 0;

                cards.forEach(card => {
                    const name = card.dataset.name;
                    const price = parseFloat(card.dataset.price);
                    const category = card.dataset.category;
                    const brand = card.dataset.brand;
                    
                    const matchesSearch = name.includes(searchTerm);
                    const matchesPrice = price >= minPrice && price <= maxPrice;
                    const matchesCategory = selectedCategories.includes('all') || selectedCategories.includes(category);
                    const matchesBrand = selectedBrands.includes('all') || selectedBrands.includes(brand);
                    
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
                const sortBy = document.getElementById('sortSelect').value;
                const grid = document.getElementById('productsGrid');
                const cards = Array.from(document.querySelectorAll('.product-card'));
                
                cards.sort((a, b) => {
                    switch(sortBy) {
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
                    }
                });
                
                cards.forEach(card => grid.appendChild(card));
            }
        });
    </script>
</x-app-layout>
