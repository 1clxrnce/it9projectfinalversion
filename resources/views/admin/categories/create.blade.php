<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">Create Category</h2>
                <p class="text-sm text-gray-400 mt-1">Add a new product category</p>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Category Information</h3>
                            <p class="text-red-100 text-sm">Enter the details for the new category</p>
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

                    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="category_name" class="block text-sm font-bold text-gray-300 uppercase tracking-wider mb-3">
                                Category Name
                            </label>
                            <input type="text" 
                                   name="category_name" 
                                   id="category_name" 
                                   value="{{ old('category_name') }}" 
                                   required 
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                                   placeholder="Enter category name...">
                        </div>

                        <div>
                            <label for="image" class="block text-sm font-bold text-gray-300 uppercase tracking-wider mb-3">
                                Category Image
                            </label>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create Category
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