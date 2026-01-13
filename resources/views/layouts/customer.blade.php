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
    <style>
        /* Custom Scrollbar for hidden look but functional */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50">
    <div class="min-h-screen bg-gray-50 flex flex-col items-center">
        <!-- Header / Gradient Background -->
        <div class="w-full bg-gradient-to-b from-blue-600 to-blue-800 pb-20 pt-8 px-4 shadow-lg rounded-b-[2.5rem]">
            <div class="max-w-md mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <a href="#" class="text-white text-2xl font-bold tracking-tight">RestoQR</a>
                </div>
                 <!-- Slot for specific header content (like table info) -->
                @if (isset($header))
                    <div class="text-white">
                        {{ $header }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Main Content Area - Overlapping the Header -->
        <div class="w-full max-w-md px-4 -mt-12 mb-20">
            {{ $slot }}
        </div>

        <!-- Bottom Navigation (Optional, maybe for Cart status) -->
        <!-- 
        <div class="fixed bottom-0 w-full max-w-md bg-white border-t border-gray-200 p-4 shadow-lg">
             Navigation Keys
        </div> 
        -->
    </div>
</body>
</html>
