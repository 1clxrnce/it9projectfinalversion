<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Inventory Overview') }}</h2>
            <a href="{{ route('transactions.create') }}" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 font-medium">
                Add Transaction
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Brand</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($products as $product)
                                @php
                                    $stock = $product->inventory ? $product->inventory->quantity : 0;
                                    $statusClass = $stock > 20 ? 'bg-green-100 text-green-800' : ($stock > 5 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800');
                                    $statusText = $stock > 20 ? 'In Stock' : ($stock > 5 ? 'Low Stock' : 'Critical');
                                @endphp
                                <tr>
                                    <td class="px-6 py-4">{{ $product->product_name }}</td>
                                    <td class="px-6 py-4">{{ $product->category->category_name }}</td>
                                    <td class="px-6 py-4">{{ $product->brand->brand_name }}</td>
                                    <td class="px-6 py-4">₱{{ number_format($product->price, 2) }}</td>
                                    <td class="px-6 py-4 font-bold">{{ $stock }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('transactions.create') }}?product={{ $product->product_id }}" class="text-green-600 hover:underline">
                                            Add Transaction
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
