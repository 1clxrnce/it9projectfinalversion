<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">{{ __('Edit Brand') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-700">
                <div class="p-6">
                    @if($errors->any())
                        <div class="bg-red-900/50 border border-red-500 text-red-300 px-4 py-3 rounded mb-4">
                            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.brands.update', $brand->brand_id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-6">
                            <label for="brand_name" class="block text-sm font-medium text-gray-300 mb-2">Brand Name</label>
                            <input type="text" name="brand_name" id="brand_name" value="{{ old('brand_name', $brand->brand_name) }}" required class="w-full bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                        </div>
                        <div class="mb-6">
                            <label for="image" class="block text-sm font-medium text-gray-300 mb-2">Brand Image</label>
                            @if($brand->image)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->brand_name }}" class="w-32 h-32 object-cover rounded-lg border border-gray-600">
                                    <p class="text-sm text-gray-400 mt-1">Current image</p>
                                </div>
                            @endif
                            <input type="file" name="image" id="image" accept="image/*" class="w-full bg-gray-700 border-gray-600 text-white file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-600 file:text-white hover:file:bg-red-700 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                            <p class="text-sm text-gray-400 mt-1">Accepted formats: JPEG, PNG, JPG, GIF (Max: 2MB)</p>
                        </div>
                        <div class="flex gap-4">
                            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 font-medium transition-colors">Update Brand</button>
                            <a href="{{ route('admin.brands.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 font-medium transition-colors">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
