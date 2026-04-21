<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welcome, {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}!</h3>
                    <p class="mb-4">Role: <span class="font-bold text-blue-600">{{ ucfirst(Auth::user()->role) }}</span></p>
                    
                    <div class="mt-6 space-y-4">
                        @if(Auth::user()->isAdmin())
                            <div class="border-l-4 border-blue-500 pl-4">
                                <h4 class="font-semibold text-lg mb-2">Admin Access</h4>
                                <ul class="space-y-2">
                                    <li><a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline">Manage Users</a></li>
                                    <li><a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:underline">Manage Categories</a></li>
                                    <li><a href="{{ route('admin.brands.index') }}" class="text-blue-600 hover:underline">Manage Brands</a></li>
                                    <li><a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline">Manage Products</a></li>
                                    <li><a href="{{ route('inventory.index') }}" class="text-blue-600 hover:underline">Inventory Overview</a></li>
                                    <li><a href="{{ route('transactions.index') }}" class="text-blue-600 hover:underline">View Transactions</a></li>
                                </ul>
                            </div>
                        @elseif(Auth::user()->isStaff())
                            <div class="border-l-4 border-green-500 pl-4">
                                <h4 class="font-semibold text-lg mb-2">Staff Access</h4>
                                <ul class="space-y-2">
                                    <li><a href="{{ route('inventory.index') }}" class="text-green-600 hover:underline">Inventory Overview</a></li>
                                    <li><a href="{{ route('transactions.create') }}" class="text-green-600 hover:underline font-bold">➜ Add Stock Transaction</a></li>
                                    <li><a href="{{ route('transactions.index') }}" class="text-green-600 hover:underline">View Transactions</a></li>
                                </ul>
                            </div>
                        @else
                            <div class="border-l-4 border-gray-500 pl-4">
                                <h4 class="font-semibold text-lg mb-2">Customer Access</h4>
                                <ul class="space-y-2">
                                    <li class="text-gray-600">No customer-specific features available</li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
