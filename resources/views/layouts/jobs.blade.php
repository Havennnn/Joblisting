<!DOCTYPE html>
<html lang="en" class="h-full">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('title', 'Neksjob')</title>

        <!-- Google Fonts - Match the main app layout -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Include Audiowide font for the Neksjob brand -->
        <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">

        <!-- Include both your custom CSS and Tailwind CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Tailwind CSS CDN for quick development - match app.blade.php -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>

    <body class="flex flex-col min-h-screen w-full mx-auto font-poppins">
        <!-- Include the navigation component -->
        <x-navigation />

        <!-- Flash Message Component -->
        <x-flash-message />

        <!-- Content -->
        <main class="flex-grow w-full">
            @yield('content')
        </main>

        <!-- Include the footer component -->
        <x-footer />

        <!-- Scripts -->
        @stack('scripts')
    </body>
</html>
