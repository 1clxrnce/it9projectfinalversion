<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Manage Brands') }}</h2>
            <a href="{{ route('admin.brands.create') }}" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 font-medium">Add Brand</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <!-- Card View -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                @foreach($brands as $brand)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <!-- Brand Image -->
                        <div class="relative h-32 bg-gray-50 flex items-center justify-center p-4">
                            @if($brand->image)
                                <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->brand_name }}" class="max-h-full max-w-full object-contain">
                            @else
                                <div class="text-gray-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Brand Info -->
                        <div class="p-4 text-center">
                            <h3 class="font-bold text-base text-gray-800 mb-2 truncate" title="{{ $brand->brand_name }}">
                                {{ $brand->brand_name }}
                            </h3>
                            
                            <div class="mb-3">
                                <span class="text-sm text-gray-600">{{ $brand->products_count }} Products</span>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('admin.brands.edit', $brand->brand_id) }}" class="w-full bg-blue-500 text-white text-center px-3 py-2 rounded-lg hover:bg-blue-600 transition text-sm font-medium">
                                    Edit
                                </a>
                                <form action="{{ route('admin.brands.destroy', $brand->brand_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="w-full bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition text-sm font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $brands->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
