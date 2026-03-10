<x-app-layout>
    <x-slot name="title">Detalles del Animal</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-bovi-dark">
                Perfil del Animal
            </h2>
            <span class="px-3 py-1 text-xs font-semibold rounded-full text-white bg-bovi-green-600">
                ID: #{{ $animal->id }}
            </span>
        </div>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto">

        <!-- Breadcrumb mejorado -->
        <nav class="mb-6 flex items-center space-x-2 text-sm">
            <a href="{{ route('dashboard') }}" class="text-gray-500 transition-colors flex items-center hover:text-bovi-green-800">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-700 font-medium">Detalles del Animal</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Columna Principal -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Card Header con información principal -->
                <div class="rounded-xl shadow-lg p-8 text-white bg-gradient-bovi-green-v">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <h1 class="text-4xl font-bold">
                                    {{ $animal->nombre ?? 'Sin nombre' }}
                                </h1>
                            </div>
                            <p class="text-sm text-bovi-green-200">{{ $animal->raza }} • {{ ucfirst($animal->sexo) }}</p>
                        </div>
                            <span class="px-4 py-2 backdrop-blur-sm rounded-lg text-sm font-semibold bg-white/20">
                                {{ $animal->codigo_nfc }}
                            </span>
                    </div>
                    
                    <!-- Stats rápidas -->
                    <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-white/20">
                        @if($animal->fecha_nacimiento)
                        <div class="text-center">
                            <p class="text-3xl font-bold">{{ \Carbon\Carbon::parse($animal->fecha_nacimiento)->age }}</p>
                            <p class="text-sm mt-1 text-bovi-green-200">años</p>
                        </div>
                        @endif
                        @if($animal->peso_aproximado)
                        <div class="text-center">
                            <p class="text-3xl font-bold">{{ $animal->peso_aproximado }}</p>
                            <p class="text-sm mt-1 text-bovi-green-200">kg</p>
                        </div>
                        @endif
                        <div class="text-center">
                            <p class="text-3xl font-bold">{{ $animal->photos->count() + ($animal->foto_boca ? 1 : 0) + ($animal->foto_general ? 1 : 0) }}</p>
                            <p class="text-sm mt-1 text-bovi-green-200">fotos</p>
                        </div>
                    </div>
                </div>

                <!-- Información Detallada -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold flex items-center text-bovi-dark">
                            <svg class="w-5 h-5 mr-2 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Información Detallada
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Código NFC -->
                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Código NFC</label>
                                <div class="flex items-center p-4 rounded-lg border-l-4 bg-bovi-green-50 border-l-bovi-green-800">
                                    <svg class="w-5 h-5 mr-3 text-bovi-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                    <span class="font-mono text-lg font-bold text-gray-800">{{ $animal->codigo_nfc }}</span>
                                </div>
                            </div>

                            <!-- Nombre -->
                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Nombre del Animal</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 transition-colors hover:border-bovi-green-600">
                                    <p class="text-lg font-semibold text-gray-800">{{ $animal->nombre ?? 'Sin nombre' }}</p>
                                </div>
                            </div>

                            <!-- Raza -->
                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Raza</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 transition-colors hover:border-bovi-green-600">
                                    <p class="text-lg font-semibold text-gray-800">{{ $animal->raza }}</p>
                                </div>
                            </div>

                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Sexo</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold text-white {{ $animal->sexo === 'macho' ? 'bg-bovi-green-600' : 'bg-bovi-brown-300' }}">
                                        {{ ucfirst($animal->sexo) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Fecha de Nacimiento -->
                            @if($animal->fecha_nacimiento)
                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Fecha de Nacimiento</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 transition-colors hover:border-bovi-green-600">
                                    <p class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($animal->fecha_nacimiento)->format('d/m/Y') }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($animal->fecha_nacimiento)->age }} años de edad
                                    </p>
                                </div>
                            </div>
                            @endif

                            <!-- Peso -->
                            @if($animal->peso_aproximado)
                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Peso Aproximado</label>
                                <div class="p-4 rounded-lg border-l-4 bg-bovi-green-50 border-l-bovi-green-800">
                                    <p class="text-2xl font-bold text-gray-800">{{ $animal->peso_aproximado }} <span class="text-sm text-gray-600">kg</span></p>
                                </div>
                            </div>
                            @endif

                            <!-- Color -->
                            @if($animal->color)
                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Color</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 transition-colors hover:border-bovi-green-600">
                                    <p class="text-lg font-semibold text-gray-800">{{ $animal->color }}</p>
                                </div>
                            </div>
                            @endif

                            <!-- Fecha de Registro -->
                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Fecha de Registro</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-lg font-semibold text-gray-800">{{ $animal->created_at->format('d/m/Y') }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $animal->created_at->format('H:i') }} hrs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                @if($animal->observaciones)
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold flex items-center text-bovi-dark">
                            <svg class="w-5 h-5 mr-2 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Observaciones
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-lg">
                            <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $animal->observaciones }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Imágenes -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold flex items-center text-bovi-dark">
                            <svg class="w-5 h-5 mr-2 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Galería de Imágenes
                        </h2>
                    </div>

                    <div class="p-6">
                        @if($animal->foto_boca || $animal->foto_general)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Foto de la Boca -->
                                @if($animal->foto_boca)
                                <div class="group">
                                    <div class="relative overflow-hidden rounded-lg shadow-lg transition-transform duration-300 group-hover:scale-105">
                                        <img 
                                            src="{{ asset('storage/' . $animal->foto_boca) }}" 
                                            alt="Foto de la boca" 
                                            class="w-full h-64 object-cover cursor-pointer"
                                            onclick="openImageModal('{{ asset('storage/' . $animal->foto_boca) }}')"
                                        >
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4 cursor-pointer"
                                            onclick="openImageModal('{{ asset('storage/' . $animal->foto_boca) }}')">
                                            <div class="text-white">
                                                <p class="font-bold text-lg">Foto de la Boca</p>
                                                <p class="text-sm flex items-center mt-1">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                                    </svg>
                                                    Click para ampliar
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Foto General -->
                                @if($animal->foto_general)
                                <div class="group">
                                    <div class="relative overflow-hidden rounded-lg shadow-lg transition-transform duration-300 group-hover:scale-105">
                                        <img 
                                            src="{{ asset('storage/' . $animal->foto_general) }}" 
                                            alt="Foto general" 
                                            class="w-full h-64 object-cover cursor-pointer"
                                            onclick="openImageModal('{{ asset('storage/' . $animal->foto_general) }}')"
                                        >
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4 cursor-pointer"
                                            onclick="openImageModal('{{ asset('storage/' . $animal->foto_general) }}')">
                                            <div class="text-white">
                                                <p class="font-bold text-lg">Foto General</p>
                                                <p class="text-sm flex items-center mt-1">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                                    </svg>
                                                    Click para ampliar
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-400 font-medium">No hay imágenes disponibles</p>
                                <p class="text-gray-400 text-sm mt-1">Agrega fotos para documentar mejor este animal</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Sidebar Derecho -->
            <div class="lg:col-span-1">
                <div class="sticky top-6 space-y-6 max-h-[calc(100vh-3rem)] overflow-y-auto pr-2 custom-scrollbar">
                
                    <!-- Acciones Rápidas -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-bovi-dark">Acciones Rápidas</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a 
                            href="{{ route('admin.ganado.edit', $animal->id) }}" 
                            class="flex items-center justify-center w-full text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 bg-bovi-green-600 hover:bg-bovi-green-700"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar Animal
                        </a>
                        
                        <button 
                            onclick="openDeleteModal({{ $animal->id }}, '{{ $animal->codigo_nfc }}')" 
                            class="flex items-center justify-center w-full bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Eliminar Animal
                        </button>
                    </div>
                </div>

                <!-- URL Pública -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b bg-gradient-to-r from-bovi-green-50 to-bovi-green-25 border-b-bovi-green-600">
                        <h3 class="text-lg font-bold flex items-center text-bovi-dark">
                            <svg class="w-5 h-5 mr-2 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            Enlace Público
                        </h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                            Comparte este enlace para que otros puedan ver la información del animal sin necesidad de cuenta.
                        </p>
                        <div class="space-y-3">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    value="{{ route('public.animal.show', $animal->public_token) }}" 
                                    readonly 
                                    class="input-bovi w-full text-sm pr-10"
                                    id="publicUrl"
                                >
                                <button 
                                    onclick="copyPublicUrl()" 
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 transition-colors hover:text-bovi-green-800"
                                    title="Copiar URL"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <button 
                                    onclick="copyPublicUrl()" 
                                    class="flex items-center justify-center text-white px-4 py-2 rounded-lg font-medium transition-all text-sm shadow-sm hover:shadow-md bg-bovi-brown-600 hover:bg-bovi-brown-800"
                                >
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Copiar
                                </button>
                                <a 
                                    href="{{ route('public.animal.show', $animal->public_token) }}" 
                                    target="_blank"
                                    class="flex items-center justify-center text-white px-4 py-2 rounded-lg font-medium transition-all text-sm shadow-sm hover:shadow-md bg-bovi-green-800 hover:bg-bovi-green-600"
                                >
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    Abrir
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Sistema -->
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl shadow-md p-6 border border-gray-200">
                    <h3 class="text-sm font-bold mb-4 flex items-center text-bovi-dark">
                        <svg class="w-4 h-4 mr-2 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Información del Registro
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex flex-col gap-1">
                            <span class="text-xs uppercase text-bovi-brown-600">Fecha de Registro</span>
                            <span class="font-semibold text-gray-800">{{ $animal->created_at->format('d/m/Y H:i') }}</span>
                            <span class="text-xs text-gray-500">{{ $animal->created_at->diffForHumans() }}</span>
                        </div>
                        
                        @if($animal->created_at != $animal->updated_at)
                        <div class="flex flex-col gap-1 pt-3 border-t border-gray-300">
                            <span class="text-xs uppercase text-bovi-brown-600">Última Modificación</span>
                            <span class="font-semibold text-gray-800">{{ $animal->updated_at->format('d/m/Y H:i') }}</span>
                            <span class="text-xs text-gray-500">{{ $animal->updated_at->diffForHumans() }}</span>
                        </div>
                        @endif
                        
                        <div class="flex flex-col gap-1 pt-3 border-t border-gray-300">
                            <span class="text-xs uppercase text-bovi-brown-600">ID del Registro</span>
                            <span class="font-mono font-semibold text-gray-800">#{{ str_pad($animal->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        
                        <div class="flex flex-col gap-1 pt-3 border-t border-gray-300">
                            <span class="text-xs uppercase text-bovi-brown-600">Token Público</span>
                            <code class="font-mono text-xs text-gray-700 bg-white px-2 py-1 rounded break-all">{{ $animal->public_token }}</code>
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>

        <!-- Formulario oculto para eliminar -->
        <form id="delete-form-{{ $animal->id }}" action="{{ route('admin.ganado.destroy', $animal->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>

    </div>

    <!-- Estilos personalizados -->
    <style>
        /* Scrollbar personalizado para el sidebar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
    </style>

    <!-- Modal de Confirmación de Eliminación Mejorado -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center px-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95" id="modalContent">
            <div class="p-6">
                <div class="flex justify-center mb-4">
                    <div class="bg-red-100 rounded-full p-4 animate-pulse">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 text-center mb-2">
                    ¿Eliminar animal?
                </h3>
                <p class="text-gray-600 text-center mb-2">
                    Estás a punto de eliminar permanentemente el animal:
                </p>
                <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-6">
                    <p class="text-center font-mono font-bold text-red-700" id="animalCode"></p>
                </div>
                <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-6 rounded">
                    <div class="flex">
                        <svg class="w-5 h-5 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <p class="text-sm text-amber-800">
                            Esta acción <strong>no se puede deshacer</strong>. Todos los datos asociados se eliminarán permanentemente.
                        </p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button 
                        onclick="closeDeleteModal()" 
                        class="flex-1 bg-gray-100 text-gray-700 font-semibold py-3 px-4 rounded-lg hover:bg-gray-200 transition-all duration-200"
                    >
                        Cancelar
                    </button>
                    <button 
                        onclick="confirmDelete()" 
                        class="flex-1 bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold py-3 px-4 rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-200 shadow-lg"
                    >
                        Sí, eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ver imagen en grande Mejorado -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black/95 backdrop-blur-sm z-50 flex items-center justify-center px-4" onclick="closeImageModal()">
        <button class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors z-10 bg-black/50 rounded-full p-2 hover:bg-black/70" onclick="closeImageModal()">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="max-w-6xl w-full" onclick="event.stopPropagation()">
            <img id="modalImage" src="" alt="Imagen ampliada" class="w-full rounded-lg shadow-2xl">
        </div>
    </div>

    <script>
        let deleteFormId = null;

        function openDeleteModal(animalId, codigoNfc) {
            deleteFormId = animalId;
            document.getElementById('animalCode').textContent = codigoNfc;
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('modalContent');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('modalContent');
            
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                deleteFormId = null;
            }, 300);
        }

        function confirmDelete() {
            if (deleteFormId) {
                document.getElementById('delete-form-' + deleteFormId).submit();
            }
        }

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!document.getElementById('deleteModal').classList.contains('hidden')) {
                    closeDeleteModal();
                }
                if (!document.getElementById('imageModal').classList.contains('hidden')) {
                    closeImageModal();
                }
            }
        });

        function copyPublicUrl() {
            const input = document.getElementById('publicUrl');
            input.select();
            input.setSelectionRange(0, 99999);
            
            navigator.clipboard.writeText(input.value).then(function() {
                // Crear notificación
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center transform translate-x-full transition-transform duration-300';
                notification.style.backgroundColor = '#1F4D2B';
                notification.innerHTML = `
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    URL copiada al portapapeles
                `;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 10);
                
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }).catch(function() {
                // Fallback para navegadores antiguos
                document.execCommand('copy');
                alert('URL copiada al portapapeles');
            });
        }

        function openImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            const modal = document.getElementById('imageModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Animación de entrada
            setTimeout(() => {
                modal.style.opacity = '1';
            }, 10);
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.style.opacity = '0';
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 200);
        }

        // Mejorar experiencia de carga de imágenes
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img[onclick^="openImageModal"]');
            images.forEach(img => {
                img.style.cursor = 'zoom-in';
            });
        });
    </script>

</x-app-layout>
