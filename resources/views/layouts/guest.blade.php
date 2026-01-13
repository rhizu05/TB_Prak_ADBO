<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RestoQR') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6', // Royal Blue
                        secondary: '#1E40AF',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
</head>
<body class="font-sans text-gray-900 antialiased bg-blue-50">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-600 to-blue-900">
        <div>
            <a href="/" class="text-white text-3xl font-bold tracking-tight">
                RestoQR
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white/10 backdrop-blur-lg shadow-xl overflow-hidden sm:rounded-xl border border-white/20">
            {{ $slot }}
        </div>
        
        <div class="mt-8 text-center text-blue-200 text-sm">
            &copy; {{ date('Y') }} RestoQR. All rights reserved.
        </div>
    </div>
</body>
</html>
