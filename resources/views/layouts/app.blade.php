<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Senior Citizen MMS') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        @auth
            <aside class="w-64 bg-indigo-800 text-white flex-shrink-0 hidden md:block">
                <div class="p-4 text-xl font-bold border-b border-indigo-700">
                    Senior Citizen MMS
                </div>
                <nav class="mt-4 space-y-1 px-2">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700' : 'hover:bg-indigo-600' }}">Dashboard</a>
                        <a href="{{ route('admin.memberships.index') }}" class="block px-4 py-2 rounded-md {{ request()->routeIs('admin.memberships.*') ? 'bg-indigo-700' : 'hover:bg-indigo-600' }}">Memberships</a>
                        <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-indigo-700' : 'hover:bg-indigo-600' }}">User Management</a>
                        <a href="{{ route('admin.reports.index') }}" class="block px-4 py-2 rounded-md {{ request()->routeIs('admin.reports.*') ? 'bg-indigo-700' : 'hover:bg-indigo-600' }}">Reports</a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 rounded-md {{ request()->routeIs('user.dashboard') ? 'bg-indigo-700' : 'hover:bg-indigo-600' }}">My Dashboard</a>
                        <a href="{{ route('user.profile.edit') }}" class="block px-4 py-2 rounded-md {{ request()->routeIs('user.profile.*') ? 'bg-indigo-700' : 'hover:bg-indigo-600' }}">Edit Profile</a>
                    @endif
                </nav>
            </aside>
        @endauth

        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        @auth
                            <span class="text-sm text-gray-600">
                                {{ auth()->user()->name }}
                                <span class="ml-1 px-2 py-0.5 text-xs rounded-full {{ auth()->user()->isAdmin() ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst(auth()->user()->role) }}
                                </span>
                            </span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-red-600 hover:underline">Logout</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>