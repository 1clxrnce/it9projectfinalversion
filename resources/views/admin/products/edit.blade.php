<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-white leading-tight">Edit Product</h2>
                <p class="text-sm text-gray-400 mt-1">Update product information and details</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-blue-900/50 text-blue-300 rounded-full text-sm font-medium">
                    ID: {{ $product->product_id }}
                </span>
                @if($product->inventory)
                    <span class="px-3 py-1 {{ $product->inventory->quantity <= 10 ? 'bg-red-900/50 text-red-300' : 'bg-green-900/50 text-green-300' }} rounded-full text-sm font-medium">
                        Stock: {{ $product->inventory->quantity ?? 0 }}
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Product Details Panel --}}
                <div class="lg:col-span-1">
                    <div class="bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden">
                        {{-- Product Image --}}
                        <div class="h-64 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center p-6">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->product_name }}" 
                                     class="max-h-full max-w-full object-contain rounded-lg">
                            @else
                                <div class="text-gray-500 text-center">
                                    <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-sm">No image</p>
                                </div>
                            @endif
                        </div>

                        {{-- Product Info --}}
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-4">{{ $product->product_name }}</h3>
                            
                            {{-- Current Details --}}
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-400">Current Price</label>
                                    <p class="text-2xl font-bold text-red-400">₱{{ number_format($product->price, 2) }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-400">Category</label>
                                    <p class="text-white font-medium">{{ $product->category->category_name ?? 'N/A' }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-400">Brand</label>
                                    <div class="flex items-center gap-2 mt-1">
                                        @if($product->brand && $product->brand->image)
                                            <img src="{{ asset('storage/' . $product->brand->image) }}" 
                                                 alt="{{ $product->brand->brand_name }}" 
                                                 class="w-6 h-6 object-contain">
                                        @endif
                                        <p class="text-white font-medium">{{ $product->brand->brand_name ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                @if($product->inventory)
                                <div>
                                    <label class="text-sm font-medium text-gray-400">Current Stock</label>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-lg font-bold {{ $product->inventory->quantity <= 10 ? 'text-red-400' : 'text-green-400' }}">
                                            {{ $product->inventory->quantity }}
                                        </span>
                                        <span class="text-sm text-gray-400">units</span>
                                        @if($product->inventory->quantity <= 10)
                                            <span class="px-2 py-1 bg-red-900/50 text-red-300 rounded text-xs">Low Stock</span>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                @if($product->description)
                                <div>
                                    <label class="text-sm font-medium text-gray-400">Description</label>
                                    <p class="text-gray-300 text-sm mt-1 leading-relaxed">{{ $product->description }}</p>
                                </div>
                                @endif

                                <div>
                                    <label class="text-sm font-medium text-gray-400">Created</label>
                                    <p class="text-gray-300 text-sm">{{ $product->created_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-400">Last Updated</label>
                                    <p class="text-gray-300 text-sm">{{ $product->updated_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Edit Form Panel --}}
                <div class="lg:col-span-2">
                    <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-white mb-2">Edit Product Information</h3>
                            <p class="text-gray-400 text-sm">Update the product details below</p>
                        </div>

                        @if($errors->any())
                            <div class="bg-red-900/50 border border-red-500 text-red-300 px-4 py-3 rounded-lg mb-6">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li class="text-sm">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.products.update', $product->product_id) }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')

                            {{-- Product Name --}}
                            <div>
                                <label for="product_name" class="block text-sm font-medium text-gray-300 mb-2">Product Name</label>
                                <input type="text" name="product_name" id="product_name" 
                                       value="{{ old('product_name', $product->product_name) }}" 
                                       required 
                                       class="w-full bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm">
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                                <textarea name="description" id="description" rows="4" 
                                          placeholder="Enter product description..."
                                          class="w-full bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm">{{ old('description', $product->description) }}</textarea>
                            </div>

                            {{-- Product Image --}}
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-300 mb-2">Product Image</label>
                                <div class="space-y-3">
                                    @if($product->image)
                                        <div class="flex items-center gap-4 p-3 bg-gray-700/50 rounded-lg">
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->product_name }}" 
                                                 class="w-16 h-16 object-cover rounded-lg border border-gray-600">
                                            <div>
                                                <p class="text-sm text-gray-300 font-medium">Current image</p>
                                                <p class="text-xs text-gray-400">Upload a new image to replace this one</p>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" name="image" id="image" accept="image/*" 
                                           class="w-full bg-gray-700 border-gray-600 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-600 file:text-white hover:file:bg-red-700 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm">
                                    <p class="text-xs text-gray-400">Accepted formats: JPEG, PNG, JPG, GIF (Max: 2MB)</p>
                                </div>
                            </div>

                            {{-- Price, Category, Brand Grid --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-300 mb-2">Price (₱)</label>
                                    <input type="number" step="0.01" name="price" id="price" 
                                           value="{{ old('price', $product->price) }}" 
                                           required 
                                           class="w-full bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm">
                                </div>

                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                                    <select name="category_id" id="category_id" required 
                                            class="w-full bg-gray-700 border-gray-600 text-white focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->category_id }}" 
                                                    {{ old('category_id', $product->category_id) == $category->category_id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="brand_id" class="block text-sm font-medium text-gray-300 mb-2">Brand</label>
                                    <select name="brand_id" id="brand_id" required 
                                            class="w-full bg-gray-700 border-gray-600 text-white focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm">
                                        <option value="">Select Brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->brand_id }}" 
                                                    {{ old('brand_id', $product->brand_id) == $brand->brand_id ? 'selected' : '' }}>
                                                {{ $brand->brand_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex gap-4 pt-6 border-t border-gray-700">
                                <button type="submit" 
                                        class="bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700 font-medium transition-colors flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Product
                                </button>
                                <a href="{{ route('admin.products.index') }}" 
                                   class="bg-gray-600 text-white px-8 py-3 rounded-lg hover:bg-gray-700 font-medium transition-colors flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
