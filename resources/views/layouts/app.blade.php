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
    {{-- Breeze account pages (profile) share the admin shell --}}
    <body class="font-sans antialiased bg-void text-bone">
        <div class="min-h-screen">
            @include('layouts.partials.admin-sidebar')

            <div class="lg:ml-64">
                @include('layouts.partials.admin-topbar')

                <main class="p-4 sm:p-6 lg:p-8">
                    @isset($header)
                        <div class="rf-page-h">
                            <div>
                                <span class="rf-label">Cuenta</span>
                                {{ $header }}
                            </div>
                        </div>
                    @endisset

                    {{ $slot }}
                </main>
            </div>
        </div>

        @include('layouts.partials.admin-scripts')
    </body>
</html>
