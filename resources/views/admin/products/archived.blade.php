<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">Archived Products</h2>
                <p class="text-sm text-gray-400 mt-1">Restore or permanently delete archived products</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="bg-gradient-to-r from-slate-600 to-slate-700 text-white px-6 py-3 rounded-xl hover:from-slate-700 hover:to-slate-800 font-medium shadow-lg transition-all duration-200 w-full sm:w-auto text-center">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Products
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-emerald-900/50 border-l-4 border-emerald-500 text-emerald-300 px-6 py-4 rounded-xl mb-6 shadow-sm flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if($products->isEmpty())
                <div class="bg-gray-800 rounded-2xl border border-gray-700 p-12 text-center">
                    <svg class="w-24 h-24 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-white mb-2">No Archived Products</h3>
                    <p class="text-gray-400">Deleted products will appear here</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($products as $product)
                    <div class="bg-gray-800 rounded-2xl border border-gray-700 hover:border-gray-600 hover:shadow-xl hover:shadow-gray-900/50 transition-all duration-300 overflow-hidden opacity-75 group">
                        
                        {{-- Product Image --}}
                        <div class="relative bg-gradient-to-br from-gray-700 to-gray-800 h-64 flex items-center justify-center p-6 overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->product_name }}" 
                                     class="max-h-full max-w-full object-contain grayscale group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="text-gray-600">
                                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            {{-- Archived Badge --}}
                            <div class="absolute top-4 left-4">
                                <span class="backdrop-blur-md bg-gray-600/90 text-white text-xs px-3 py-1.5 rounded-full font-semibold shadow-lg">
                                    Archived
                                </span>
                            </div>
                        </div>

                        {{-- Product Info --}}
                        <div class="p-6">
                            {{-- Category & Brand Pills --}}
                            <div class="flex items-center gap-2 mb-3 flex-wrap">
                                <span class="text-xs text-gray-400 bg-gray-700 px-3 py-1.5 rounded-lg font-medium">{{ $product->category->category_name }}</span>
                                <span class="text-xs text-gray-400 bg-gray-700 px-3 py-1.5 rounded-lg font-semibold">{{ $product->brand ? $product->brand->brand_name : 'No Brand' }}</span>
                            </div>

                            {{-- Product Name --}}
                            <h3 class="font-bold text-white mb-2 line-clamp-2 min-h-[3.5rem] text-lg group-hover:text-gray-200 transition-colors" title="{{ $product->product_name }}">
                                {{ $product->product_name }}
                            </h3>

                            {{-- Price --}}
                            <div class="pt-4 border-t border-gray-700 mb-4">
                                <span class="text-2xl sm:text-3xl font-bold text-white">₱{{ number_format($product->price, 2) }}</span>
                            </div>

                            {{-- Actions --}}
                            <div class="flex gap-2">
                                <form action="{{ route('admin.products.restore', $product->product_id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full bg-emerald-500 text-white px-4 py-2.5 rounded-lg hover:bg-emerald-600 transition font-medium flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Restore
                                    </button>
                                </form>
                                <form action="{{ route('admin.products.forceDelete', $product->product_id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Permanently delete this product? This cannot be undone!')" class="w-full bg-rose-500 text-white px-4 py-2.5 rounded-lg hover:bg-rose-600 transition font-medium flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete Forever
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
