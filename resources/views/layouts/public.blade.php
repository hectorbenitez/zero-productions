<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $settings->company_name ?? 'Zero Productions')</title>
    <meta name="description" content="@yield('description', 'Producción de eventos y conciertos de primer nivel.')">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', $settings->company_name ?? 'Zero Productions')">
    <meta property="og:description" content="@yield('og_description', 'Producción de eventos y conciertos de primer nivel.')">
    <meta property="og:type" content="website">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#000000">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|bebas-neue:400" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-primary: #3b82f6;
            --color-primary-dark: #2563eb;
            --color-dark: #0f0f0f;
            --color-darker: #050505;
        }
    </style>
</head>
<body class="font-sans antialiased bg-neutral-950 text-white min-h-screen flex flex-col">
    @include('partials.navbar')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
