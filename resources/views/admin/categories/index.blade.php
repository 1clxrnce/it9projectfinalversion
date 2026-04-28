<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">Categories</h2>
                <p class="text-sm text-gray-400 mt-1">Organize products into categories</p>
            </div>
            <div class="flex gap-3 w-full sm:w-auto">
                <a href="{{ route('admin.categories.archived') }}" class="bg-slate-600 text-white px-6 py-3 rounded-xl hover:bg-slate-700 font-medium shadow-lg transition-all duration-200 flex-1 sm:flex-initial text-center">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        Archive
                    </span>
                </a>
                <a href="{{ route('admin.categories.create') }}" class="bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-3 rounded-xl hover:from-red-700 hover:to-red-800 font-medium shadow-lg shadow-red-500/30 transition-all duration-200 hover:shadow-xl hover:shadow-red-500/40 flex-1 sm:flex-initial text-center">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Category
                    </span>
                </a>
            </div>
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

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                @foreach($categories as $category)
                <div class="bg-gray-800 rounded-2xl border border-gray-700 hover:border-red-500 hover:shadow-xl hover:shadow-red-500/20 transition-all duration-300 group relative">
                    {{-- Three Dot Menu --}}
                    <div class="absolute top-3 right-3 z-50">
                        <button class="dropdown-toggle w-8 h-8 bg-gray-700/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-gray-600 transition shadow-lg">
                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                            </svg>
                        </button>
                        <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-xl shadow-xl border border-gray-700 py-2 z-50">
                            <a href="{{ route('admin.categories.edit', $category->category_id) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-red-900/50 hover:text-red-400 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Category
                            </a>
                            <hr class="my-2 border-gray-700">
                            <form action="{{ route('admin.categories.destroy', $category->category_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Move this category to archive?')" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-400 hover:bg-red-900/50 transition text-left">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    Archive Category
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Category Image/Icon --}}
                    <div class="h-32 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center p-4 rounded-t-2xl overflow-hidden relative">
                        @if($category->image && file_exists(public_path('storage/' . $category->image)))
                            {{-- Display uploaded image --}}
                            <img src="{{ asset('storage/' . $category->image) }}" 
                                 alt="{{ $category->category_name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            {{-- Fallback icon --}}
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
                                $catData = $categoryIcons[$catName] ?? ['icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', 'color' => 'from-red-500 to-red-600'];
                            @endphp
                            <div class="w-16 h-16 bg-gradient-to-br {{ $catData['color'] }} rounded-xl flex items-center justify-center text-white group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $catData['icon'] }}"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Category Info --}}
                    <div class="p-4 text-center">
                        <h3 class="font-bold text-base text-white mb-2 truncate" title="{{ $category->category_name }}">
                            {{ $category->category_name }}
                        </h3>
                        
                        <div class="pt-3 border-t border-gray-700">
                            <div class="flex items-center justify-center gap-2 text-sm text-gray-400">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>
                                </svg>
                                <span class="font-semibold text-white">{{ $category->products_count }}</span> Products
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
</x-app-layout>