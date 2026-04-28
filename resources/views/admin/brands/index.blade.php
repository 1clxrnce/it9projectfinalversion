<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">Brands</h2>
                <p class="text-sm text-gray-400 mt-1">Manage product brands and manufacturers</p>
            </div>
            <div class="flex gap-3 w-full sm:w-auto">
                <a href="{{ route('admin.brands.archived') }}" class="bg-slate-600 text-white px-6 py-3 rounded-xl hover:bg-slate-700 font-medium shadow-lg transition-all duration-200 flex-1 sm:flex-initial text-center">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        Archive
                    </span>
                </a>
                <a href="{{ route('admin.brands.create') }}" class="bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-3 rounded-xl hover:from-red-700 hover:to-red-800 font-medium shadow-lg shadow-red-500/30 transition-all duration-200 hover:shadow-xl hover:shadow-red-500/40 flex-1 sm:flex-initial text-center">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Brand
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
                @foreach($brands as $brand)
                <div class="bg-gray-800 rounded-2xl border border-gray-700 hover:border-red-500 hover:shadow-xl hover:shadow-red-500/20 transition-all duration-300 group relative">
                    {{-- Three Dot Menu - Only visible on hover --}}
                    <div class="absolute top-3 right-3 z-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <button class="dropdown-toggle w-8 h-8 bg-gray-700/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-gray-600 transition shadow-lg">
                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                            </svg>
                        </button>
                        <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-xl shadow-xl border border-gray-700 py-2 z-50">
                            <a href="{{ route('admin.brands.edit', $brand->brand_id) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-red-900/50 hover:text-red-400 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Brand
                            </a>
                            <hr class="my-2 border-gray-700">
                            <form action="{{ route('admin.brands.destroy', $brand->brand_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Move this brand to archive?')" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-400 hover:bg-red-900/50 transition text-left">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    Archive Brand
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Brand Image --}}
                    <div class="h-32 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center p-4 rounded-t-2xl overflow-hidden">
                        @if($brand->image)
                            <img src="{{ asset('storage/' . $brand->image) }}" 
                                 alt="{{ $brand->brand_name }}" 
                                 class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="text-gray-500 flex flex-col items-center">
                                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <span class="text-xs">No Logo</span>
                            </div>
                        @endif
                    </div>

                    {{-- Brand Info --}}
                    <div class="p-4 text-center">
                        <h3 class="font-bold text-base text-white mb-2 truncate" title="{{ $brand->brand_name }}">
                            {{ $brand->brand_name }}
                        </h3>
                        
                        <div class="pt-3 border-t border-gray-700">
                            <div class="flex items-center justify-center gap-2 text-sm text-gray-400">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>
                                </svg>
                                <span class="font-semibold text-white">{{ $brand->products_count }}</span> Products
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
