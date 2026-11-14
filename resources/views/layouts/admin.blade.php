<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#0a0a0a">

    <!-- Scripts (Riff fonts are self-hosted through app.css) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-void text-bone">
    <div class="min-h-screen">
        @include('layouts.partials.admin-sidebar')

        <!-- Main Content -->
        <div class="lg:ml-64">
            @include('layouts.partials.admin-topbar')

            <main class="p-4 sm:p-6 lg:p-8">
                @include('layouts.partials.admin-flash')

                @yield('content')
            </main>
        </div>
    </div>

    @include('layouts.partials.admin-scripts')

    @stack('scripts')
</body>
</html>
