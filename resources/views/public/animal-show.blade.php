<x-public-layout :title="($animal->nombre ?? $animal->codigo_nfc) . ' - BoviTrack'">

    <div class="max-w-2xl mx-auto py-6 px-4 sm:py-10 sm:px-6">

        <!-- Header con diseño mejorado -->
        <div class="mb-8 text-center">
            <!-- Logo BoviTrack -->
            <div class="inline-flex items-center justify-center mb-4">
                <img 
                    src="{{ asset('img/logo.png') }}" 
                    alt="BoviTrack Logo" 
                    class="w-20 h-20 sm:w-24 sm:h-24 object-contain drop-shadow-lg"
                >
            </div>
            
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 tracking-tight text-bovi-dark">
                {{ $animal->nombre ?? 'Animal #' . $animal->codigo_nfc }}
            </h1>
            
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-200">
                <div class="w-2 h-2 rounded-full animate-pulse bg-bovi-green-600"></div>
                <p class="text-gray-600 text-sm font-medium">Vista pública</p>
            </div>
        </div>

        <!-- Card Principal con diseño mejorado -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            
            <!-- Header de la card -->
            <div class="card-header-green">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="bi bi-info-circle"></i>
                    Información Básica
                </h2>
            </div>

            <div class="p-6 space-y-5">
                <!-- Código NFC - Destacado -->
                <div class="card-info-item-green rounded-xl p-4 border-l-4 border-l-bovi-green-800">
                    <p class="text-xs font-semibold uppercase tracking-wider mb-1 flex items-center gap-1 text-bovi-green-800">
                        <i class="bi bi-upc-scan"></i> Código NFC
                    </p>
                    <p class="font-bold text-2xl font-mono text-bovi-green-800">{{ $animal->codigo_nfc }}</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nombre -->
                    @if($animal->nombre)
                    <div class="card-info-item-beige rounded-xl p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider mb-2 flex items-center gap-1 text-bovi-brown-600">
                            <i class="bi bi-tag"></i> Nombre
                        </p>
                        <p class="font-bold text-lg text-bovi-dark">{{ $animal->nombre }}</p>
                    </div>
                    @endif

                    <!-- Raza -->
                    <div class="card-info-item-green rounded-xl p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider mb-2 flex items-center gap-1 text-bovi-green-800">
                            <i class="bi bi-clipboard-data"></i> Raza
                        </p>
                        <p class="font-bold text-lg text-bovi-green-800">{{ $animal->raza }}</p>
                    </div>

                    <!-- Sexo -->
                    <div class="card-info-item-brown rounded-xl p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider mb-2 flex items-center gap-1 text-bovi-brown-600">
                            <i class="bi bi-gender-ambiguous"></i> Sexo
                        </p>
                        <p class="font-bold text-lg text-bovi-brown-800">
                            {{ $animal->sexo === 'macho' ? '♂ Macho' : '♀ Hembra' }}
                        </p>
                    </div>

                    <!-- Fecha de Nacimiento -->
                    @if($animal->fecha_nacimiento)
                    <div class="card-info-item-amber rounded-xl p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider mb-2 flex items-center gap-1 text-bovi-brown-600">
                            <i class="bi bi-calendar-event"></i> F. Nacimiento
                        </p>
                        <p class="font-bold text-lg text-bovi-brown-800">{{ \Carbon\Carbon::parse($animal->fecha_nacimiento)->format('d/m/Y') }}</p>
                    </div>
                    @endif

                    <!-- Peso -->
                    @if($animal->peso_aproximado)
                    <div class="card-info-item-green rounded-xl p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider mb-2 flex items-center gap-1 text-bovi-green-700">
                            <i class="bi bi-speedometer2"></i> Peso Aprox.
                        </p>
                        <p class="font-bold text-lg text-bovi-green-800">{{ $animal->peso_aproximado }} kg</p>
                    </div>
                    @endif

                    <!-- Color -->
                    @if($animal->color)
                    <div class="card-info-item-brown rounded-xl p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider mb-2 flex items-center gap-1 text-bovi-brown-600">
                            <i class="bi bi-palette"></i> Color
                        </p>
                        <p class="font-bold text-lg text-bovi-brown-800">{{ $animal->color }}</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Observaciones -->
        @if($animal->observaciones)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            
            <div class="card-header-brown">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="bi bi-journal-text"></i>
                    Observaciones
                </h2>
            </div>

            <div class="p-6">
                <div class="rounded-xl p-4 border-l-4 bg-amber-50 border-l-bovi-brown-600">
                    <p class="text-gray-800 leading-relaxed whitespace-pre-line">{{ $animal->observaciones }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Imágenes -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            
            <div class="card-header-amber">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="bi bi-camera"></i>
                    Galería de Imágenes
                </h2>
            </div>

            <div class="p-6 space-y-6">
                <!-- Foto de la Boca -->
                @if($animal->foto_boca)
                <div class="card-photo-amber">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="inline-flex items-center justify-center w-8 h-8 text-white rounded-lg text-sm font-bold bg-amber-600">
                            <i class="bi bi-mouth"></i>
                        </span>
                        <p class="text-sm font-bold uppercase tracking-wide text-amber-800">Foto de la Boca</p>
                    </div>
                    <div class="relative group">
                        <img 
                            src="{{ asset('storage/' . $animal->foto_boca) }}" 
                            alt="Foto de la boca" 
                            class="w-full rounded-xl shadow-lg border-4 border-white transition-transform duration-300 group-hover:scale-[1.02]"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                </div>
                @endif

                <!-- Foto General -->
                @if($animal->foto_general)
                <div class="card-photo-green">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="inline-flex items-center justify-center w-8 h-8 text-white rounded-lg text-sm font-bold bg-bovi-green-600">
                            <i class="bi bi-image"></i>
                        </span>
                        <p class="text-sm font-bold uppercase tracking-wide text-bovi-green-800">Foto General</p>
                    </div>
                    <div class="relative group">
                        <img 
                            src="{{ asset('storage/' . $animal->foto_general) }}" 
                            alt="Foto general" 
                            class="w-full rounded-xl shadow-lg border-4 border-white transition-transform duration-300 group-hover:scale-[1.02]"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                </div>
                @endif

                @if(!$animal->foto_boca && !$animal->foto_general)
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                        <i class="bi bi-images text-3xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 font-medium">No hay imágenes disponibles</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Footer mejorado -->
        <div class="mt-10 mb-6">
            <div class="rounded-2xl shadow-lg p-6 text-center bg-gradient-bovi-green">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <img 
                        src="{{ asset('img/logo.png') }}" 
                        alt="BoviTrack Logo" 
                        class="w-10 h-10 object-contain drop-shadow-lg"
                    >
                    <span class="text-2xl font-bold text-white">BoviTrack</span>
                </div>
                <p class="text-sm font-medium mb-1 text-bovi-green-200">Sistema de Gestión de Ganado</p>
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full mt-3 bg-white/20 backdrop-blur-sm">
                    <i class="bi bi-eye text-white"></i>
                    <p class="text-white text-xs font-semibold">Vista pública de solo lectura</p>
                </div>
            </div>

            <!-- Info adicional -->
            <div class="text-center mt-6 space-y-2">
                <p class="text-gray-500 text-xs">
                    <i class="bi bi-shield-check"></i> Información verificada y gestionada
                </p>
                <p class="text-gray-400 text-xs">
                    © {{ date('Y') }} BoviTrack - Todos los derechos reservados
                </p>
            </div>
        </div>

    </div>

</x-public-layout>
