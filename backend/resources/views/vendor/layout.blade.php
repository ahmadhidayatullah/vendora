<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Vendora — Vendor Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
        <span class="text-xl font-bold text-gray-800">Vendora <span class="text-green-600 font-normal text-sm">vendor panel</span></span>
        <div class="flex items-center gap-6 text-sm text-gray-600">
            <a href="{{ route('vendor.products.index') }}" class="hover:text-gray-900">Products</a>
            <a href="{{ route('vendor.orders.index') }}" class="hover:text-gray-900">Orders</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="hover:text-red-500">Logout</button>
            </form>
        </div>
    </nav>

    {{-- Flash messages --}}
    <div class="max-w-6xl mx-auto px-6 mt-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 text-sm px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 text-sm px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- Content --}}
    <main class="max-w-6xl mx-auto px-6 py-8">
        @yield('content')
    </main>

</body>
</html>