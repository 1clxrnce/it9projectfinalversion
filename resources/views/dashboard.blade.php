<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">Dashboard</h2>
                <p class="text-sm text-gray-400 mt-1">Welcome back, {{ Auth::user()->firstName }}!</p>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- Stats Overview --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Total Products --}}
                <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6 hover:shadow-xl hover:shadow-red-500/10 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-red-400 bg-red-900/30 px-2.5 py-1 rounded-full">Products</span>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-1">{{ $totalProducts }}</h3>
                    <p class="text-sm text-gray-400">Total products</p>
                </div>

                {{-- Total Inventory Value --}}
                <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6 hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-emerald-400 bg-emerald-900/30 px-2.5 py-1 rounded-full">Value</span>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-1">₱{{ number_format($totalInventoryValue, 0) }}</h3>
                    <p class="text-sm text-gray-400">Inventory value</p>
                </div>

                {{-- Low Stock Alert --}}
                <div class="bg-gray-800 rounded-2xl border border-orange-700/50 p-6 hover:shadow-xl hover:shadow-orange-500/10 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-orange-400 bg-orange-900/30 px-2.5 py-1 rounded-full animate-pulse">Alert</span>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-1">{{ $lowStockProducts }}</h3>
                    <p class="text-sm text-gray-400">Low stock items</p>
                </div>

                {{-- Out of Stock --}}
                <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6 hover:shadow-xl hover:shadow-gray-500/10 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-gray-600 to-gray-700 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-400 bg-gray-700 px-2.5 py-1 rounded-full">Empty</span>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-1">{{ $outOfStockProducts }}</h3>
                    <p class="text-sm text-gray-400">Out of stock</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Low Stock Products --}}
                <div class="lg:col-span-2 bg-gray-800 rounded-2xl border border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-white">Low Stock Alert</h3>
                            <p class="text-sm text-gray-400">Products that need restocking</p>
                        </div>
                        <a href="{{ route('admin.products.index') }}" class="text-sm text-red-400 hover:text-red-300 font-medium">View All →</a>
                    </div>

                    @if($lowStockItems->isEmpty())
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-emerald-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-400 font-medium">All products are well stocked!</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($lowStockItems as $item)
                            <div class="flex items-center gap-4 p-4 bg-gray-700 rounded-xl hover:bg-gray-600 transition">
                                <div class="w-12 h-12 bg-gray-600 rounded-lg flex items-center justify-center flex-shrink-0 border border-gray-500">
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->product_name }}" class="w-10 h-10 object-contain">
                                    @else
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-white truncate">{{ $item->product_name }}</h4>
                                    <p class="text-sm text-gray-400">{{ $item->category->category_name }} • {{ $item->brand->brand_name ?? 'No Brand' }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                                        <span class="text-lg font-bold text-red-400">{{ $item->inventory->quantity }}</span>
                                    </div>
                                    <a href="{{ route('transactions.create') }}?product={{ $item->product_id }}" class="text-xs text-red-400 hover:text-red-300 font-medium">Add Stock →</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Quick Actions --}}
                <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-white mb-6">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.products.create') }}" class="flex items-center gap-3 p-4 bg-gradient-to-r from-red-900/30 to-red-800/30 rounded-xl hover:from-red-900/50 hover:to-red-800/50 transition group border border-red-700/50">
                            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Add Product</p>
                                <p class="text-xs text-gray-400">Create new product</p>
                            </div>
                        </a>

                        @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 p-4 bg-gray-700 rounded-xl hover:bg-gray-600 transition group">
                            <div class="w-10 h-10 bg-gray-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition">
                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Manage Users</p>
                                <p class="text-xs text-gray-400">{{ $totalUsers }} users</p>
                            </div>
                        </a>
                        @endif

                        <a href="{{ route('transactions.create') }}" class="flex items-center gap-3 p-4 bg-emerald-900/30 rounded-xl hover:bg-emerald-900/50 transition group border border-emerald-700/50">
                            <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Add Stock</p>
                                <p class="text-xs text-gray-400">New transaction</p>
                            </div>
                        </a>

                        <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 p-4 bg-gray-700 rounded-xl hover:bg-gray-600 transition group">
                            <div class="w-10 h-10 bg-gray-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition">
                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Transactions</p>
                                <p class="text-xs text-gray-400">View history</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Stock by Category --}}
            <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-white">Stock by Category</h3>
                        <p class="text-sm text-gray-400">Inventory distribution across categories</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($stockByCategory as $category)
                    <div class="p-4 bg-gray-700 rounded-xl hover:bg-gray-600 transition">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-white text-sm truncate">{{ $category['name'] }}</h4>
                        </div>
                        <p class="text-2xl font-bold text-red-400">{{ $category['stock'] }}</p>
                        <p class="text-xs text-gray-400">{{ $category['products'] }} products</p>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>