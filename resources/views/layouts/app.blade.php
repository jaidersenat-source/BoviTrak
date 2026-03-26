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
                <footer class="footer-bovi">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Columna 1: Acerca de -->
                            <div>
                                <h3 class="text-lg font-bold mb-4 flex items-center">
                                    <svg class="w-6 h-6 mr-2 footer-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Acerca de BoviTrack
                                </h3>
                                <p class="text-gray-300 text-sm leading-relaxed">
                                    Sistema profesional de gestión ganadera para el control, seguimiento y administración de ganado bovino mediante tecnología NFC.
                                </p>
                            </div>

                            <!-- Columna 2: Enlaces Rápidos -->
                            <div>
                                <h3 class="text-lg font-bold mb-4 flex items-center">
                                    <svg class="w-6 h-6 mr-2 footer-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                    Enlaces Rápidos
                                </h3>
                                <ul class="space-y-2 text-sm">
                                    <li>
                                        <a href="{{ route('dashboard') }}" class="footer-link flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                            Panel Principal
                                        </a>
                                    </li>
                                  
                                    <li>
                                    <a href="{{ route('profile.edit') }}" class="footer-link flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Mi Perfil
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Columna 3: Información de Contacto -->
                        <div>
                            <h3 class="text-lg font-bold mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 footer-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Soporte
                            </h3>
                            <ul class="space-y-2 text-sm text-gray-300">
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0 footer-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Disponible 24/7</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0 footer-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    <span>Datos seguros y protegidos</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0 footer-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <span>Tecnología NFC avanzada</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-700 mt-8 pt-6">
                        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                            <div class="text-sm text-gray-400">
                                &copy; {{ date('Y') }} BoviTrack. Todos los derechos reservados.
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-400">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Sistema en línea
                                </span>
                                <span class="hidden md:inline">•</span>
                                <span>Versión 1.0.0</span>
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
