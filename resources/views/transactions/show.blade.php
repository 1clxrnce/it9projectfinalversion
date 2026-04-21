<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-bold text-lg">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-6 text-center">Stock Transaction Completed</h3>

                    <!-- Transaction Details -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h4 class="font-semibold text-lg mb-4 border-b pb-2">Transaction Details</h4>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Transaction ID</p>
                                <p class="font-semibold">#{{ $transaction->transaction_id }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Date & Time</p>
                                <p class="font-semibold">{{ $transaction->transactionDate->format('M d, Y h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Transaction Type</p>
                                <p class="font-semibold">
                                    <span class="px-3 py-1 rounded text-sm
                                        @if($transaction->transactionType === 'in') bg-green-100 text-green-800
                                        @elseif($transaction->transactionType === 'out') bg-red-100 text-red-800
                                        @else bg-blue-100 text-blue-800 @endif">
                                        {{ ucfirst($transaction->transactionType) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Processed By</p>
                                <p class="font-semibold">{{ $transaction->user->firstName }} {{ $transaction->user->lastName }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Product Information -->
                    <div class="bg-blue-50 rounded-lg p-6 mb-6">
                        <h4 class="font-semibold text-lg mb-4 border-b pb-2">Product Information</h4>
                        
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Product Name</p>
                            <p class="font-bold text-xl">{{ $transaction->product->product_name }}</p>
                        </div>
                        
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Category</p>
                                <p class="font-semibold">{{ $transaction->product->category->category_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Brand</p>
                                <p class="font-semibold">{{ $transaction->product->brand->brand_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Price</p>
                                <p class="font-semibold">₱{{ number_format($transaction->product->price, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Changes -->
                    <div class="bg-yellow-50 rounded-lg p-6 mb-6">
                        <h4 class="font-semibold text-lg mb-4 border-b pb-2">Stock Changes</h4>
                        
                        <div class="flex items-center justify-center space-x-8">
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-2">Previous Stock</p>
                                <p class="text-4xl font-bold text-gray-700">
                                    {{ session('oldQuantity', $transaction->product->inventory ? $transaction->product->inventory->quantity : 0) }}
                                </p>
                            </div>
                            
                            <div class="text-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                            
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-2">New Stock</p>
                                <p class="text-4xl font-bold text-green-600">
                                    {{ session('newQuantity', $transaction->product->inventory ? $transaction->product->inventory->quantity : 0) }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <p class="text-sm text-gray-600">Quantity Changed</p>
                            <p class="text-2xl font-bold 
                                @if($transaction->transactionType === 'in') text-green-600
                                @elseif($transaction->transactionType === 'out') text-red-600
                                @else text-blue-600 @endif">
                                @if($transaction->transactionType === 'in') +
                                @elseif($transaction->transactionType === 'out') -
                                @endif
                                {{ $transaction->quantity }} units
                            </p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-4 justify-center">
                        <a href="{{ route('transactions.create') }}" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 font-medium">
                            Add Another Transaction
                        </a>
                        <a href="{{ route('inventory.index') }}" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 font-medium">
                            View Inventory
                        </a>
                        <a href="{{ route('transactions.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 font-medium">
                            View All Transactions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
