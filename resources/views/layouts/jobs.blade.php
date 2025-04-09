<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('title', 'Neksjob')</title>

        <!-- Tailwind CSS is included via the tailwind.config.js file -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Audiowide/Neksjob font -->
        <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">

        <!-- Inter Font Family -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>

    <body class="bg-gray-50">
        <!-- Include the navigation component -->
        <x-navigation />

        <!-- Content -->
        <main>
            @yield('content')
        </main>

        <!-- Include the footer component -->
        <x-footer />
    </body>
</html>
