<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Sistema de Gestión Ganadera para el control y seguimiento de tu ganado bovino.">
        <meta name="keywords" content="ganadería, bovinos, gestión ganadera, control de animales, BoviTrack">

        <title>{{ isset($title) ? $title . ' - ' : '' }}{{ config('app.name', 'BoviTrack') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100">
            <!-- Logo Container -->
            <div class="mb-8 transform transition-all duration-300 hover:scale-105">
                <a href="/" class="flex items-center justify-center">
                    <x-application-logo class="w-16 h-16 sm:w-20 sm:h-20 fill-current text-gray-700" />
                </a>
            </div>

            <!-- Card Container -->
            <div class="w-full max-w-sm sm:max-w-md auth-container">
                <div class="bg-white/80 backdrop-blur-sm shadow-2xl rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-3xl border border-gray-100">
                    <div class="px-6 py-8 sm:px-10 sm:py-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    © {{ date('Y') }} BoviTrack. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </body>
</html>
