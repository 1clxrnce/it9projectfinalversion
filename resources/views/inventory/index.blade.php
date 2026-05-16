<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-white leading-tight">{{ __('Inventory Overview') }}</h2>
                <p class="text-sm text-gray-400 mt-1">Monitor stock levels across all products</p>
            </div>
            <a href="{{ route('transactions.create') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 font-medium shadow-lg shadow-red-500/30 transition-all duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Transaction
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-900">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Brand</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Stock</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                            @forelse($products as $product)
                                @php
                                    $stock = $product->inventory ? $product->inventory->quantity : 0;
                                    if ($stock > 20) {
                                        $statusClass = 'bg-emerald-900/50 text-emerald-300 border border-emerald-500/50';
                                        $statusText = 'In Stock';
                                    } elseif ($stock > 5) {
                                        $statusClass = 'bg-yellow-900/50 text-yellow-300 border border-yellow-500/50';
                                        $statusText = 'Low Stock';
                                    } else {
                                        $statusClass = 'bg-red-900/50 text-red-300 border border-red-500/50';
                                        $statusText = 'Critical';
                                    }
                                @endphp
                                <tr class="hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-medium text-white">{{ $product->product_name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-300">{{ $product->category->category_name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-300">{{ $product->brand ? $product->brand->brand_name : 'No Brand' }}</td>
                                    <td class="px-6 py-4 text-sm text-white font-medium">₱{{ number_format($product->price, 2) }}</td>
                                    <td class="px-6 py-4 text-sm font-bold text-white">{{ $stock }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('transactions.create') }}?product={{ $product->product_id }}" class="text-red-400 hover:text-red-300 font-medium transition-colors">
                                            Add Transaction
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="bg-gray-900 px-6 py-4 border-t border-gray-700">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
