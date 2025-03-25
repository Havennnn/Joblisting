<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Neksjob - Applicant')</title>

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
<body class="flex flex-col min-h-screen">
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
