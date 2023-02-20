<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <!-- Styles -->
    <link rel="stylesheet" href="vendor/notify-me/notifyme.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @stack('styles')
</head>
<body class="antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Page Heading -->
        @if($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main class="w-full">
            <section class="bg-blue-50 dark:bg-gray-900">
                <div class="pt-8 lg:pt-16 px-4 mx-auto max-w-screen-md">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">
                        {{ $contentHeader }}
                    </h2>
                    <p class="mb-2 lg:mb-4 font-light text-center text-gray-500 dark:text-gray-400 sm:text-xl">
                        {{ $contentSummary }}
                    </p>
                </div>
                <div class="pt-4 lg:pt-8 pb-8 px-4 w-full">
                    {{ $slot }}
                </div>
            </section>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
