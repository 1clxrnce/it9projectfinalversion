<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-900 text-white">

    @auth
        @if(Auth::user()->isAdmin() || Auth::user()->isStaff())
            {{-- Sidebar Layout --}}
            <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: true }">

                {{-- Sidebar --}}
                <aside :class="sidebarOpen ? 'w-64' : 'w-16'"
                       class="bg-gray-900 text-white flex flex-col transition-all duration-300 h-full shrink-0 fixed lg:relative top-0 z-40 overflow-hidden">

                    {{-- Logo / Toggle --}}
                    <div class="flex items-center justify-between px-4 py-4 border-b border-gray-800">
                        <div x-show="sidebarOpen" class="flex items-center gap-3">
                            <img src="{{ asset('storage/logo/logo.png') }}" alt="BJ Computers Logo" class="w-8 h-8 object-contain">
                            <span class="text-lg font-bold truncate text-white">
                                {{ config('app.name') }}
                            </span>
                        </div>
                        <div x-show="!sidebarOpen" class="flex items-center justify-center w-full">
                            <img src="{{ asset('storage/logo/logo.png') }}" alt="BJ Computers Logo" class="w-8 h-8 object-contain">
                        </div>
                        <button @click="sidebarOpen = !sidebarOpen"
                                class="text-gray-400 hover:text-white focus:outline-none transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Nav Items --}}
                    <nav class="flex-1 py-4 space-y-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-gray-800" x-data="{
                        openGroup: '{{ request()->routeIs('admin.*') ? 'admin' : (request()->routeIs('transactions.*') ? 'transactions' : '') }}'
                    }">

                        {{-- Main Section --}}
                        <div class="px-4 mb-4">
                            <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Main</div>
                            <div x-show="!sidebarOpen" class="h-px bg-gray-700 mb-2"></div>
                        </div>

                        {{-- Dashboard --}}
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-700 rounded mx-2
                                  {{ request()->routeIs('dashboard') ? 'bg-red-900/30 text-red-400 border-r-2 border-red-500' : 'text-gray-300' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span x-show="sidebarOpen" class="truncate">Dashboard</span>
                        </a>

                        {{-- Inventory Section --}}
                        <div class="px-4 mt-6 mb-4">
                            <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Inventory</div>
                            <div x-show="!sidebarOpen" class="h-px bg-gray-700 mb-2"></div>
                        </div>

                        {{-- Transactions Accordion --}}
                        <div>
                            <button @click="openGroup = openGroup === 'transactions' ? '' : 'transactions'"
                                    class="flex items-center justify-between w-full px-4 py-2 text-sm hover:bg-gray-700 rounded mx-2 {{ request()->routeIs('transactions.*') ? 'bg-red-900/30 text-red-400 border-r-2 border-red-500' : 'text-gray-300' }}"
                                    style="width: calc(100% - 1rem)">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                    <span x-show="sidebarOpen" class="truncate">Transactions</span>
                                </div>
                                <svg x-show="sidebarOpen" class="w-4 h-4 transition-transform"
                                     :class="openGroup === 'transactions' ? 'rotate-180' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="openGroup === 'transactions' && sidebarOpen"
                                 x-transition
                                 class="ml-8 mt-1 space-y-1">
                                <a href="{{ route('transactions.index') }}"
                                   class="block px-4 py-1.5 text-sm rounded hover:bg-gray-700
                                          {{ request()->routeIs('transactions.index') ? 'text-red-400 bg-red-900/20' : 'text-gray-400' }}">
                                    All Transactions
                                </a>
                                <a href="{{ route('transactions.create') }}"
                                   class="block px-4 py-1.5 text-sm rounded hover:bg-gray-700
                                          {{ request()->routeIs('transactions.create') ? 'text-red-400 bg-red-900/20' : 'text-gray-400' }}">
                                    New Transaction
                                </a>
                            </div>
                        </div>

                        {{-- Catalog Management Section --}}
                        @if(Auth::user()->isAdmin() || Auth::user()->isStaff())
                        <div class="px-4 mt-6 mb-4">
                            <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Catalog</div>
                            <div x-show="!sidebarOpen" class="h-px bg-gray-700 mb-2"></div>
                        </div>

                        {{-- Products --}}
                        <a href="{{ route('admin.products.index') }}"
                           class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-700 rounded mx-2
                                  {{ request()->routeIs('admin.products.*') ? 'bg-red-900/30 text-red-400 border-r-2 border-red-500' : 'text-gray-300' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                            </svg>
                            <span x-show="sidebarOpen" class="truncate">Products</span>
                        </a>

                        {{-- Categories --}}
                        <a href="{{ route('admin.categories.index') }}"
                           class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-700 rounded mx-2
                                  {{ request()->routeIs('admin.categories.*') ? 'bg-red-900/30 text-red-400 border-r-2 border-red-500' : 'text-gray-300' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <span x-show="sidebarOpen" class="truncate">Categories</span>
                        </a>

                        {{-- Brands --}}
                        <a href="{{ route('admin.brands.index') }}"
                           class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-700 rounded mx-2
                                  {{ request()->routeIs('admin.brands.*') ? 'bg-red-900/30 text-red-400 border-r-2 border-red-500' : 'text-gray-300' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            <span x-show="sidebarOpen" class="truncate">Brands</span>
                        </a>
                        @endif

                        {{-- Administration Section (admin only) --}}
                        @if(Auth::user()->isAdmin())
                        <div class="px-4 mt-6 mb-4">
                            <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Administration</div>
                            <div x-show="!sidebarOpen" class="h-px bg-gray-700 mb-2"></div>
                        </div>

                        {{-- Users --}}
                        <a href="{{ route('admin.users.index') }}"
                           class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-700 rounded mx-2
                                  {{ request()->routeIs('admin.users.*') ? 'bg-red-900/30 text-red-400 border-r-2 border-red-500' : 'text-gray-300' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span x-show="sidebarOpen" class="truncate">Users</span>
                        </a>
                        @endif

                    </nav>

                    {{-- User / Logout at bottom --}}
                    <div class="border-t border-gray-800 px-4 py-4 shrink-0">
                        <div x-show="sidebarOpen" class="mb-3">
                            <div class="text-sm text-gray-300 truncate font-medium">
                                {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
                            </div>
                            <div class="text-xs text-gray-500 truncate">
                                {{ Auth::user()->email }}
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('profile.edit') }}"
                               class="flex items-center justify-center w-9 h-9 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg transition-colors duration-200" 
                               title="Profile">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center justify-center w-9 h-9 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg transition-colors duration-200" 
                                        title="Logout">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </aside>

                {{-- Main content --}}
                <div class="flex-1 flex flex-col min-w-0 h-full bg-gray-900 overflow-y-auto">
                    @isset($header)
                        <header class="bg-gray-800 border-b border-gray-700 sticky top-0 z-10">
                            <div class="py-6 px-6">{{ $header }}</div>
                        </header>
                    @endisset
                    <main class="flex-1 p-6">{{ $slot }}</main>
                </div>
            </div>

        @else
            {{-- Regular user: top nav --}}
            @include('layouts.navigation')
            @isset($header)
                <header class="bg-gray-800 border-b border-gray-700">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">{{ $header }}</div>
                </header>
            @endisset
            <main class="bg-gray-900 min-h-screen">{{ $slot }}</main>
        @endif
    @else
        @include('layouts.navigation')
        @isset($header)
            <header class="bg-gray-800 border-b border-gray-700">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">{{ $header }}</div>
            </header>
        @endisset
        <main class="bg-gray-900 min-h-screen">{{ $slot }}</main>
    @endauth

    </body>
</html>
