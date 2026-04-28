<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">Edit Category</h2>
                <p class="text-sm text-gray-400 mt-1">Update category information</p>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-xl hover:bg-gray-700 font-medium shadow-lg transition-all duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Categories
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-800 rounded-2xl border border-gray-700 shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Edit Category</h3>
                            <p class="text-red-100 text-sm">Update the category information</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    @if($errors->any())
                        <div class="bg-red-900/50 border border-red-500 text-red-300 px-6 py-4 rounded-xl mb-6">
                            <div class="flex items-center gap-3 mb-2">
                                <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-semibold">Please fix the following errors:</span>
                            </div>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.categories.update', $category->category_id) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label for="category_name" class="block text-sm font-bold text-gray-300 uppercase tracking-wider mb-3">
                                Category Name
                            </label>
                            <input type="text" 
                                   name="category_name" 
                                   id="category_name" 
                                   value="{{ old('category_name', $category->category_name) }}" 
                                   required 
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                                   placeholder="Enter category name...">
                        </div>

                        <div>
                            <label for="image" class="block text-sm font-bold text-gray-300 uppercase tracking-wider mb-3">
                                Category Image
                            </label>
                            @if($category->image)
                                <div class="mb-4 flex items-center gap-4">
                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                         alt="{{ $category->category_name }}" 
                                         class="w-32 h-32 object-cover rounded-xl border-2 border-gray-600">
                                    <div>
                                        <p class="text-sm text-gray-400">Current image</p>
                                        <p class="text-xs text-gray-500 mt-1">Upload a new image to replace</p>
                                    </div>
                                </div>
                            @endif
                            <input type="file" 
                                   name="image" 
                                   id="image" 
                                   accept="image/*"
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-600 file:text-white hover:file:bg-red-700 focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                            <p class="text-xs text-gray-400 mt-2">Accepted formats: JPEG, PNG, JPG, GIF, WEBP (Max: 2MB)</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-700">
                            <button type="submit" class="bg-gradient-to-r from-red-600 to-red-700 text-white px-8 py-3 rounded-xl hover:from-red-700 hover:to-red-800 font-medium shadow-lg shadow-red-500/30 transition-all duration-200 hover:shadow-xl hover:shadow-red-500/40 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update Category
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="bg-gray-600 text-white px-8 py-3 rounded-xl hover:bg-gray-700 font-medium shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
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
</x-app-layout>