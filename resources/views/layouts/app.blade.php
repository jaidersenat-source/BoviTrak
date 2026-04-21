<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Sistema de Gestión Ganadera para el control y seguimiento de tu ganado bovino.">
        <meta name="keywords" content="ganadería, bovinos, gestión ganadera, control de animales, BoviTrack">
        <meta name="author" content="BoviTrack">

        <title>{{ isset($title) ? $title . ' - ' : '' }}{{ config('app.name', 'BoviTrack') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">
        
        <!-- Optimización de Fuentes -->
        <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
        <link rel="dns-prefetch" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-bovi-beige-100">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <div class="flex-1 flex flex-col sm:ml-64">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow-md border-b border-gray-200 animate-slide-down">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-grow">
                    <div class="animate-fade-in">
                        {{ $slot }}
                    </div>
                </main>

                <!-- Footer -->
                <footer class="footer-bovi relative z-0">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Columna 1: Acerca de (opcional) -->
                            <div class="space-y-2 text-sm text-gray-700">
                                {{-- Puedes poner logo, enlaces o descripción aquí --}}
                            </div>

                            <!-- Columna 2: (vacío/centro) -->
                            <div class="flex items-center justify-center">
                                {{-- Espacio central si hace falta --}}
                            </div>

                            <!-- Columna 3: (vacío/derecha) -->
                            <div class="flex items-center justify-end">
                                {{-- Enlaces rápidos o contacto --}}
                            </div>
                        </div>
                    </div>

                    <!-- Sólo desde la línea hacia abajo tendrá fondo oscuro -->
                    <div class="bg-[#08321f] text-gray-200">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 border-t border-gray-700">
                            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                                <div class="text-sm text-gray-200">
                                    &copy; {{ date('Y') }} BoviTrack. Todos los derechos reservados.
                                </div>

                                <div class="flex items-center space-x-4 text-sm text-gray-200">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                        </svg>
                                        <span class="text-sm">Sistema en línea</span>
                                    </span>

                                    <span class="hidden md:inline">•</span>
                                    <span class="text-sm">Versión 1.0.0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
        </div>

        <!-- Scroll to Top Button -->
        <button 
            id="scrollToTop" 
            class="btn-scroll-top hidden"
            onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
            </svg>
        </button>

        <script>
            // Mostrar/ocultar botón de scroll to top
            window.addEventListener('scroll', function() {
                const scrollBtn = document.getElementById('scrollToTop');
                if (window.pageYOffset > 300) {
                    scrollBtn.classList.remove('hidden');
                } else {
                    scrollBtn.classList.add('hidden');
                }
            });
        </script>
    </body>
</html>
