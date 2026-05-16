<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-700">
                <div class="p-6">
                    @if($errors->any())
                        <div class="bg-red-900 border border-red-700 text-red-200 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.update', $user->user_id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="firstName" class="block text-sm font-medium text-gray-300 mb-2">First Name</label>
                                <input type="text" name="firstName" id="firstName" value="{{ old('firstName', $user->firstName) }}" required class="w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent">
                            </div>
                            <div>
                                <label for="lastName" class="block text-sm font-medium text-gray-300 mb-2">Last Name</label>
                                <input type="text" name="lastName" id="lastName" value="{{ old('lastName', $user->lastName) }}" required class="w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="mobilePhone" class="block text-sm font-medium text-gray-300 mb-2">Mobile Phone</label>
                            <input type="text" name="mobilePhone" id="mobilePhone" value="{{ old('mobilePhone', $user->mobilePhone) }}" class="w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-300 mb-2">Role</label>
                            <select name="role" id="role" required class="w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent">
                                <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <div class="mb-4 border-t border-gray-700 pt-4">
                            <p class="text-sm text-gray-400 mb-2">Leave password fields empty to keep current password</p>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">New Password</label>
                                    <input type="password" name="password" id="password" class="w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent">
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-2 rounded-lg hover:from-red-700 hover:to-red-800 font-medium transition">Update User</button>
                            <a href="{{ route('admin.users.index') }}" class="bg-gray-700 text-gray-100 px-6 py-2 rounded-lg hover:bg-gray-600 font-medium transition border border-gray-600">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
