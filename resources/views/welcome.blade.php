<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js for Dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased font-sans">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 min-h-screen">
        <img id="background" class="absolute -left-20 top-0 max-w-[877px]" src="https://laravel.com/assets/img/welcome/background.svg" />

        <!-- Dropdown Container -->
        <div class="container mx-auto flex justify-center mt-20 gap-4 relative overflow-visible"> <!-- Adjusted margin here -->
            @if (Route::has('login'))
                <!-- Applicant Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="text-black dark:text-white px-4 py-2 bg-gray-200 dark:bg-gray-800 rounded-lg focus:outline-none shadow-md">
                        Applicant ▼
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute mt-2 w-48 bg-white dark:bg-gray-900 border rounded-md shadow-lg">
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-800">Applicant Log In</a>
                        <a href="{{ route('register') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-800">Applicant Register</a>
                    </div>
                </div>

                <!-- Employer Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="text-black dark:text-white px-4 py-2 bg-gray-200 dark:bg-gray-800 rounded-lg focus:outline-none shadow-md">
                        Employer ▼
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute mt-2 w-48 bg-white dark:bg-gray-900 border rounded-md shadow-lg">
                        <a href="{{ route('employer.login') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-800">Employer Log In</a>
                        <a href="{{ route('employer.register') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-800">Employer Register</a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center min-h-[75vh] selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <!-- Your main content -->
            </div>
        </div>
    </div>
</body>
</html>
