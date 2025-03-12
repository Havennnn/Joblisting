<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('pageStyles')
    </head>
    <body class="font-sans antialiased">
        <main class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @yield('content')
        </main>

        @stack('pageScripts')
        @stack('componentSripts')
    </body>
</html>
