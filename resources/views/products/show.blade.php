<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->product_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold mb-2">{{ $product->product_name }}</h1>
                        <p class="text-gray-600">{{ $product->category->category_name }} - {{ $product->brand->brand_name }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-2">Description</h3>
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="border rounded p-4">
                            <p class="text-gray-600 text-sm">Price</p>
                            <p class="text-2xl font-bold text-green-600">₱{{ number_format($product->price, 2) }}</p>
                        </div>
                        <div class="border rounded p-4">
                            <p class="text-gray-600 text-sm">Available Stock</p>
                            <p class="text-2xl font-bold {{ $product->inventory && $product->inventory->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->inventory ? $product->inventory->quantity : 0 }} units
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('admin.products.index') }}" class="inline-block bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 font-medium">
                        Back to Products
                    </a>
                    
                    @if(Auth::user()->isStaff() || Auth::user()->isAdmin())
                        <a href="{{ route('transactions.create') }}?product={{ $product->product_id }}" class="inline-block bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 font-medium">
                            Add Transaction
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
