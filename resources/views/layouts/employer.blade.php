<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Neksjob - Employer')</title>

    <!-- Include both your custom CSS and Tailwind CSS -->
    @vite(['resources/css/style.css'])

    <!-- Tailwind CSS CDN for quick development -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind configuration for colors -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'neksjob-blue': '#3674B5',
                        'neksjob-pink': '#D91656',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main {
            flex: 1;
            display: block;
            width: 100%;
            height: auto;
            min-height: calc(100vh - 150px); /* Adjust based on nav and footer height */
            overflow-y: auto;
        }
    </style>
</head>
<body>

    <!-- Navigation Component -->
    <x-navigation />

    <!-- Main Content -->
    <main class="main">
        @yield('content')
    </main>

    <!-- Footer Component -->
    <x-footer />

</body>
</html>
