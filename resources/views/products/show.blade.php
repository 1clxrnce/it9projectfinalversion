<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $product->product_name }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-900 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-700">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                    {{-- Product Image --}}
                    <div class="bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl p-8 flex items-center justify-center">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" 
                                 alt="{{ $product->product_name }}" 
                                 class="max-h-96 max-w-full object-contain">
                        @else
                            <svg class="w-32 h-32 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        @endif
                    </div>

                    {{-- Product Details --}}
                    <div class="flex flex-col">
                        <div class="mb-6">
                            <h1 class="text-3xl font-bold text-white mb-3">{{ $product->product_name }}</h1>
                            <div class="flex items-center gap-2 mb-4">
                                <span class="text-sm text-gray-400 bg-gray-700 px-3 py-1.5 rounded-lg">{{ $product->category->category_name }}</span>
                                <span class="text-sm text-red-400 bg-red-900/30 px-3 py-1.5 rounded-lg font-semibold">{{ $product->brand ? $product->brand->brand_name : 'No Brand' }}</span>
                            </div>
                        </div>

                        @if($product->description)
                        <div class="mb-6">
                            <h3 class="font-semibold text-lg mb-2 text-white">Description</h3>
                            <p class="text-gray-300 leading-relaxed">{{ $product->description }}</p>
                        </div>
                        @endif

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-gray-700 rounded-xl p-4 border border-gray-600">
                                <p class="text-gray-400 text-sm mb-1">Price</p>
                                <p class="text-2xl font-bold text-white">₱{{ number_format($product->price, 2) }}</p>
                            </div>
                            <div class="bg-gray-700 rounded-xl p-4 border border-gray-600">
                                <p class="text-gray-400 text-sm mb-1">Available Stock</p>
                                @php
                                    $quantity = $product->inventory ? $product->inventory->quantity : 0;
                                @endphp
                                <p class="text-2xl font-bold {{ $quantity > 20 ? 'text-emerald-400' : ($quantity > 0 ? 'text-yellow-400' : 'text-red-400') }}">
                                    {{ $quantity }} units
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-3 mt-auto">
                            <a href="{{ route('admin.products.index') }}" class="flex-1 bg-gray-700 text-white px-6 py-3 rounded-xl hover:bg-gray-600 font-medium text-center transition">
                                Back to Products
                            </a>
                            
                            @if(Auth::user()->isStaff() || Auth::user()->isAdmin())
                                <a href="{{ route('transactions.create') }}?product={{ $product->product_id }}" class="flex-1 bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-3 rounded-xl hover:from-red-700 hover:to-red-800 font-medium text-center shadow-lg shadow-red-500/30 transition">
                                    Add Transaction
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
