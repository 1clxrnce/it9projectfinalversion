<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Stock Transactions') }}
                </h2>
                <p class="text-sm text-gray-400 mt-1">Track all inventory movements and changes</p>
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
            @if(session('success'))
                <div class="bg-green-900/50 border border-green-500 text-green-300 px-6 py-4 rounded-lg mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-900">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Date
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>
                                        </svg>
                                        Product
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        Type
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                        Quantity
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        User
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                            @forelse($transactions as $transaction)
                                <tr class="hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-white font-medium">
                                            {{ $transaction->transactionDate->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $transaction->transactionDate->format('H:i A') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($transaction->product->image)
                                                <img src="{{ asset('storage/' . $transaction->product->image) }}" 
                                                     alt="{{ $transaction->product->product_name }}" 
                                                     class="w-10 h-10 object-cover rounded-lg border border-gray-600">
                                            @else
                                                <div class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center border border-gray-600">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-medium text-white">{{ $transaction->product->product_name }}</div>
                                                <div class="text-xs text-gray-400">{{ $transaction->product->brand->brand_name ?? 'No Brand' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                            @if($transaction->transactionType === 'in') bg-green-900/50 text-green-300 border border-green-500/50
                                            @elseif($transaction->transactionType === 'out') bg-red-900/50 text-red-300 border border-red-500/50
                                            @else bg-blue-900/50 text-blue-300 border border-blue-500/50 @endif">
                                            @if($transaction->transactionType === 'in')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Stock In
                                            @elseif($transaction->transactionType === 'out')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                                Stock Out
                                            @else
                                                {{ ucfirst($transaction->transactionType) }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold {{ $transaction->transactionType === 'in' ? 'text-green-400' : 'text-red-400' }}">
                                            {{ $transaction->transactionType === 'in' ? '+' : '-' }}{{ $transaction->quantity }}
                                        </div>
                                        <div class="text-xs text-gray-400">units</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center border border-gray-600">
                                                <span class="text-xs font-semibold text-gray-300">
                                                    {{ substr($transaction->user->firstName, 0, 1) }}{{ substr($transaction->user->lastName, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-white">{{ $transaction->user->firstName }} {{ $transaction->user->lastName }}</div>
                                                <div class="text-xs text-gray-400">{{ ucfirst($transaction->user->role) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            <div>
                                                <p class="text-gray-400 font-medium">No transactions found</p>
                                                <p class="text-gray-500 text-sm">Start by adding your first stock transaction</p>
                                            </div>
                                            <a href="{{ route('transactions.create') }}" class="mt-2 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 font-medium text-sm">
                                                Add Transaction
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($transactions->hasPages())
                    <div class="bg-gray-900 px-6 py-4 border-t border-gray-700">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-400">
                                Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} results
                            </div>
                            <div class="pagination-links">
                                {{ $transactions->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
