<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RestoQR') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6', // Royal Blue
                        secondary: '#1E40AF',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex bg-gray-50">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:block">
            <div class="h-16 flex items-center justify-center border-b border-gray-200">
                <span class="text-xl font-bold text-blue-600">RestoQR</span>
            </div>
            <nav class="mt-6 px-4 space-y-2">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} font-medium">Dashboard</a>
                    <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} font-medium">Categories</a>
                    <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} font-medium">Products</a>
                    <a href="{{ route('admin.tables.index') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.tables.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} font-medium">Tables</a>
                    <a href="{{ route('admin.reports.index') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.reports.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} font-medium">Reports</a>
                @elseif(auth()->user()->role === 'kasir')
                    <a href="{{ route('kasir.dashboard') }}" class="block px-4 py-2 rounded-lg bg-blue-50 text-blue-700 font-medium">Dashboard</a>
                    <a href="{{ route('kasir.orders.index') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('kasir.orders.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Orders</a>
                    <a href="{{ route('kasir.payments.index') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('kasir.payments.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Payments</a>
                @elseif(auth()->user()->role === 'koki')
                    <a href="{{ route('koki.dashboard') }}" class="block px-4 py-2 rounded-lg bg-blue-50 text-blue-700 font-medium">Dashboard</a>
                    <a href="{{ route('koki.kds.index') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('koki.kds.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Kitchen Display</a>
                @endif
            </nav>
            <div class="absolute bottom-0 w-64 p-4 border-t border-gray-200">
                <div class="flex items-center">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 uppercase">{{ auth()->user()->role }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg text-left">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ $header ?? 'Dashboard' }}
                    </h1>
                     <!-- Mobile menu button stub -->
                </div>
            </header>
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>
