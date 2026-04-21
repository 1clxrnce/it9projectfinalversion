<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Stock Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('transactions.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">Product</label>
                            <select name="product_id" id="product_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select a product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->product_id }}" 
                                        {{ (old('product_id') == $product->product_id || request('product') == $product->product_id) ? 'selected' : '' }}>
                                        {{ $product->product_name }} (Current Stock: {{ $product->inventory ? $product->inventory->quantity : 0 }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="transactionType" class="block text-sm font-medium text-gray-700 mb-2">Transaction Type</label>
                            <select name="transactionType" id="transactionType" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select type</option>
                                <option value="in" {{ old('transactionType') == 'in' ? 'selected' : '' }}>Stock In (Add)</option>
                                <option value="out" {{ old('transactionType') == 'out' ? 'selected' : '' }}>Stock Out (Remove)</option>
                                <option value="adjustment" {{ old('transactionType') == 'adjustment' ? 'selected' : '' }}>Adjustment (Set Exact)</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                            <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity') }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 mt-6">
                            <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 font-semibold text-base">
                                Create Transaction
                            </button>
                            <a href="{{ route('transactions.index') }}" class="w-full sm:w-auto text-center bg-gray-500 text-white px-8 py-3 rounded-lg hover:bg-gray-600 font-semibold text-base">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
