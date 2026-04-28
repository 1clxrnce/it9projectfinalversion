<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">Transaction Confirmation</h2>
                <p class="text-sm text-gray-400 mt-1">Stock transaction completed successfully</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-emerald-900/50 border-l-4 border-emerald-500 text-emerald-300 px-6 py-4 rounded-xl mb-6 shadow-sm">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-bold text-lg">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="bg-gray-800 rounded-2xl border border-gray-700 shadow-xl overflow-hidden">
                <div class="p-8">
                    <h3 class="text-2xl font-bold mb-8 text-center text-white">Stock Transaction Completed</h3>

                    <!-- Transaction Details -->
                    <div class="bg-gray-750 rounded-xl p-6 mb-6 border border-gray-700">
                        <h4 class="font-semibold text-lg mb-4 pb-3 border-b border-gray-700 text-white">Transaction Details</h4>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-400">Transaction ID</p>
                                <p class="font-semibold text-white">#{{ $transaction->transaction_id }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Date & Time</p>
                                <p class="font-semibold text-white">{{ $transaction->transactionDate->format('M d, Y h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Transaction Type</p>
                                <p class="font-semibold">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                                        @if($transaction->transactionType === 'in') bg-emerald-900/50 text-emerald-400
                                        @elseif($transaction->transactionType === 'out') bg-red-900/50 text-red-400
                                        @else bg-blue-900/50 text-blue-400 @endif">
                                        {{ ucfirst($transaction->transactionType) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Processed By</p>
                                <p class="font-semibold text-white">{{ $transaction->user->firstName }} {{ $transaction->user->lastName }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Product Information -->
                    <div class="bg-blue-900/20 rounded-xl p-6 mb-6 border border-blue-800/30">
                        <h4 class="font-semibold text-lg mb-4 pb-3 border-b border-blue-800/30 text-white">Product Information</h4>
                        
                        <div class="mb-4">
                            <p class="text-sm text-gray-400">Product Name</p>
                            <p class="font-bold text-xl text-white">{{ $transaction->product->product_name }}</p>
                        </div>
                        
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-400">Category</p>
                                <p class="font-semibold text-white">{{ $transaction->product->category->category_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Brand</p>
                                <p class="font-semibold text-white">{{ $transaction->product->brand ? $transaction->product->brand->brand_name : 'No Brand' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Price</p>
                                <p class="font-semibold text-white">₱{{ number_format($transaction->product->price, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Changes -->
                    <div class="bg-yellow-900/20 rounded-xl p-6 mb-6 border border-yellow-800/30">
                        <h4 class="font-semibold text-lg mb-4 pb-3 border-b border-yellow-800/30 text-white">Stock Changes</h4>
                        
                        <div class="flex items-center justify-center space-x-8">
                            <div class="text-center">
                                <p class="text-sm text-gray-400 mb-2">Previous Stock</p>
                                <p class="text-4xl font-bold text-gray-300">
                                    {{ session('oldQuantity', $transaction->product->inventory ? $transaction->product->inventory->quantity : 0) }}
                                </p>
                            </div>
                            
                            <div class="text-center">
                                <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                            
                            <div class="text-center">
                                <p class="text-sm text-gray-400 mb-2">New Stock</p>
                                <p class="text-4xl font-bold text-emerald-400">
                                    {{ session('newQuantity', $transaction->product->inventory ? $transaction->product->inventory->quantity : 0) }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <p class="text-sm text-gray-400">Quantity Changed</p>
                            <p class="text-2xl font-bold 
                                @if($transaction->transactionType === 'in') text-emerald-400
                                @elseif($transaction->transactionType === 'out') text-red-400
                                @else text-blue-400 @endif">
                                @if($transaction->transactionType === 'in') +
                                @elseif($transaction->transactionType === 'out') -
                                @endif
                                {{ $transaction->quantity }} units
                            </p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                        <a href="{{ route('transactions.create') }}" class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-6 py-3 rounded-xl hover:from-emerald-700 hover:to-emerald-800 font-medium shadow-lg transition-all duration-200 text-center">
                            Add Another Transaction
                        </a>
                        <a href="{{ route('inventory.index') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 font-medium shadow-lg transition-all duration-200 text-center">
                            View Inventory
                        </a>
                        <a href="{{ route('transactions.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-xl hover:bg-gray-700 font-medium shadow-lg transition-all duration-200 text-center">
                            View All Transactions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
