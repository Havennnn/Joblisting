<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel') . ' - Setup')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Include both your custom CSS and Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwind CSS CDN for quick development -->
    <script src="https://cdn.tailwindcss.com"></script>
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
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-neksjob-pink hover:text-neksjob-blue px-3 py-2 text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <x-flash-message />

        <!-- Page Content -->
        <main class="flex-grow w-full">
            @yield('content')
        </main>

        <!-- Footer using component -->
        <x-footer />
    </div>

    @livewireScripts
    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
