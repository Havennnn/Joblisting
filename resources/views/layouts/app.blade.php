<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Neksjob')</title>

    <!-- Include both your custom CSS and Tailwind CSS -->
    @vite(['resources/css/style.css'])

    <!-- Tailwind CSS CDN for quick development -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="flex flex-col min-h-screen overflow-x-hidden">
    <!-- Navigation Component -->
    <div class="w-full">
        <x-navigation />
    </div>

    <!-- Main Content -->
    <main class="flex-grow w-full">
        @yield('content')
    </main>

    <!-- Footer Component -->
    <div class="w-full">
        <x-footer />
    </div>
</body>
</html>
