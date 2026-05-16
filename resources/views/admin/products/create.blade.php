<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">{{ __('Create Product') }}</h2>
    </x-slot>

    <div class="py-8 bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-700">
                <div class="p-8">
                    @if($errors->any())
                        <div class="bg-red-900/50 border border-red-500 text-red-300 px-4 py-3 rounded-lg mb-6">
                            <ul class="space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label for="product_name" class="block text-sm font-semibold text-gray-300 mb-2">Product Name</label>
                            <input type="text" name="product_name" id="product_name" value="{{ old('product_name') }}" required 
                                   class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-300 mb-2">Description</label>
                            <textarea name="description" id="description" rows="4" 
                                      class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-transparent transition">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label for="image" class="block text-sm font-semibold text-gray-300 mb-2">Product Image</label>
                            <input type="file" name="image" id="image" accept="image/*" 
                                   class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 rounded-lg text-gray-300 focus:ring-2 focus:ring-red-500 focus:border-transparent transition file:bg-red-600 file:text-white file:border-0 file:rounded file:px-3 file:py-1 file:cursor-pointer">
                            <p class="text-xs text-gray-400 mt-2">Accepted formats: JPEG, PNG, JPG, GIF (Max: 2MB)</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label for="price" class="block text-sm font-semibold text-gray-300 mb-2">Price (₱)</label>
                                <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" required 
                                       class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label for="category_id" class="block text-sm font-semibold text-gray-300 mb-2">Category</label>
                                <select name="category_id" id="category_id" required 
                                        class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="brand_id" class="block text-sm font-semibold text-gray-300 mb-2">Brand</label>
                                <select name="brand_id" id="brand_id" required 
                                        class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->brand_id }}" {{ old('brand_id') == $brand->brand_id ? 'selected' : '' }}>
                                            {{ $brand->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-2.5 rounded-lg hover:from-red-700 hover:to-red-800 font-semibold shadow-lg shadow-red-500/30 transition-all duration-200">
                                Create Product
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="bg-gray-700 text-white px-6 py-2.5 rounded-lg hover:bg-gray-600 font-semibold transition-all duration-200">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
