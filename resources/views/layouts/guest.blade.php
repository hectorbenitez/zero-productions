<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <meta name="theme-color" content="#0a0a0a">

        <!-- Scripts (Riff fonts are self-hosted through app.css) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-bone antialiased bg-void">
        <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 py-10">
            <a href="/" class="flex flex-col items-center gap-3 focus-visible:outline focus-visible:outline-2 focus-visible:outline-focus">
                <img src="{{ asset('assets/logo-zero-productions-invert.png') }}" alt="Zero Productions" class="h-12 w-auto object-contain">
                <span class="rf-label text-riff-text">Panel de administración</span>
            </a>

            <div class="w-full sm:max-w-md mt-8 p-6 sm:p-8 bg-amp border border-rule border-t-4 border-t-riff">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
