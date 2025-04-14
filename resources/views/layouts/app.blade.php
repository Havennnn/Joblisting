<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Neksjob')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Include both your custom CSS and Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwind CSS CDN for quick development -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="flex flex-col min-h-screen w-full mx-auto font-poppins">
    <!-- Navigation Component -->
    <x-navigation />

    <!-- Flash Message Component -->
    <x-flash-message />

    <!-- Main Content -->
    <main class="flex-grow w-full">
        @yield('content')
    </main>

    <!-- Footer Component -->
    <x-footer />

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
