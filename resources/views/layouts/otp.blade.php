<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel') . ' - OTP')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-white-100 flex flex-col">
        <!-- Navigation using component -->
        <nav class="w-full bg-white border-b border-gray-200 py-3">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <div class="flex-shrink-0">
                        <a href="/" class="flex items-center">
                            <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-8 w-auto">
                        </a>
                    </div>
                    <div class="flex items-center">
                        <form method="POST" action="/logout-during-otp" class="inline">
                            @csrf
                            <button type="submit" class="text-neksjob-pink hover:text-neksjob-blue px-3 py-2 text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer using component -->
        <x-footer />
    </div>

    @livewireScripts
    @yield('scripts')
</body>
</html>
