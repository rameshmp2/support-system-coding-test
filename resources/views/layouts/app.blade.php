<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Online Support')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="sticky top-0 z-10 border-b border-gray-200 bg-white">
        <div class="container flex items-center justify-between gap-3 py-3">
            <a href="{{ route('tickets.create') }}" class="text-lg font-bold text-gray-900">🎧 Online Support</a>

            <nav class="hidden items-center gap-6 md:flex">
                <a href="{{ route('tickets.create') }}" class="text-gray-700 hover:text-blue-600">Open a ticket</a>
                <a href="{{ route('status.index') }}" class="text-gray-700 hover:text-blue-600">Check status</a>
                @auth
                    <a href="{{ route('agent.tickets.index') }}" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-transparent p-0 text-gray-700 hover:text-blue-600">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Agent login</a>
                @endauth
            </nav>

            <button
                type="button"
                id="nav-toggle"
                class="inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-gray-100 md:hidden"
                aria-controls="mobile-menu"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <svg id="nav-icon-open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg id="nav-icon-close" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav id="mobile-menu" class="hidden border-t border-gray-200 md:hidden">
            <div class="container flex flex-col gap-1 py-2">
                <a href="{{ route('tickets.create') }}" class="rounded-md px-2 py-2 text-gray-700 hover:bg-gray-50">Open a ticket</a>
                <a href="{{ route('status.index') }}" class="rounded-md px-2 py-2 text-gray-700 hover:bg-gray-50">Check status</a>
                @auth
                    <a href="{{ route('agent.tickets.index') }}" class="rounded-md px-2 py-2 text-gray-700 hover:bg-gray-50">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-md px-2 py-2 text-left text-blue-600 hover:bg-gray-50">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-md px-2 py-2 text-gray-700 hover:bg-gray-50">Agent login</a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">© {{ date('Y') }} Online Support System</div>
    </footer>

    @stack('scripts')
</body>
</html>