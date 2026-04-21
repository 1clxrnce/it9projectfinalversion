<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($products as $product)
                            <div class="border rounded-lg p-4 hover:shadow-lg transition">
                                <h3 class="font-bold text-lg mb-2">{{ $product->product_name }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $product->category->category_name }} - {{ $product->brand->brand_name }}</p>
                                <p class="text-gray-700 mb-3">{{ Str::limit($product->description, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xl font-bold text-green-600">₱{{ number_format($product->price, 2) }}</span>
                                    <span class="text-sm {{ $product->inventory && $product->inventory->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Stock: {{ $product->inventory ? $product->inventory->quantity : 0 }}
                                    </span>
                                </div>
                                <a href="{{ route('products.show', $product->product_id) }}" class="mt-4 block text-center bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 font-medium">
                                    View Details
                                </a>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-8 text-gray-500">
                                No products available.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
