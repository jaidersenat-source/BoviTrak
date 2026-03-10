<x-app-layout>
    <x-slot name="title">Registrar Ganado</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-bovi-dark">
                <svg class="inline-block w-8 h-8 mr-2 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Registrar Ganado
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <!-- Mensajes de Error -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow-md p-4 mb-6 animate-fade-in">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div class="flex-1">
                        <h3 class="font-bold text-red-800 mb-2">Hay errores en el formulario:</h3>
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-red-500 hover:text-red-700 ml-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Mensajes de Éxito -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg shadow-md p-4 mb-6 animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-green-500 hover:text-green-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow-md p-4 mb-6 animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('admin.ganado.store') }}" enctype="multipart/form-data" id="ganadoForm">
            @csrf

            <!-- Sección: Información Básica -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-6 overflow-hidden transform transition-all duration-300 hover:shadow-xl">
                <div class="card-header-green">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Información Básica
                    </h3>
                </div>
                <div class="p-6 space-y-5">

                    <!-- Código NFC -->
                    <div>
                        <label for="codigo_nfc" class="block text-sm font-semibold text-gray-700 mb-2">
                            Código NFC <span class="text-red-600">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="codigo_nfc" 
                            id="codigo_nfc"
                            value="{{ old('codigo_nfc') }}"
                            placeholder="Ingrese código NFC único"
                            class="input-bovi w-full @error('codigo_nfc') border-red-500 bg-red-50 @enderror"
                            required
                        >
                        @error('codigo_nfc')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Requerido. Debe ser único.</p>
                    </div>

                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nombre
                        </label>
                        <input 
                            type="text" 
                            name="nombre" 
                            id="nombre"
                            value="{{ old('nombre') }}"
                            placeholder="Ej: Brahman 01"
                            class="input-bovi w-full @error('nombre') border-red-500 bg-red-50 @enderror"
                        >
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Opcional</p>
                    </div>

                    <!-- Raza -->
                    <div>
                        <label for="raza" class="block text-sm font-semibold text-gray-700 mb-2">
                            Raza <span class="text-red-600">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="raza" 
                            id="raza"
                            value="{{ old('raza') }}"
                            placeholder="Ej: Brahman, Angus, Nelore"
                            class="input-bovi w-full @error('raza') border-red-500 bg-red-50 @enderror"
                            required
                        >
                        @error('raza')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Requerido</p>
                    </div>

                    <!-- Sexo -->
                    <div>
                        <label for="sexo" class="block text-sm font-semibold text-gray-700 mb-2">
                            Sexo <span class="text-red-600">*</span>
                        </label>
                        <select 
                            name="sexo" 
                            id="sexo"
                            class="input-bovi w-full @error('sexo') border-red-500 bg-red-50 @enderror"
                            required
                        >
                            <option value="">-- Seleccione una opción --</option>
                            <option value="macho" {{ old('sexo') == 'macho' ? 'selected' : '' }}>Macho</option>
                            <option value="hembra" {{ old('sexo') == 'hembra' ? 'selected' : '' }}>Hembra</option>
                        </select>
                        @error('sexo')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Requerido</p>
                    </div>

                </div>
            </div>

            <!-- Sección: Datos Físicos -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-6 overflow-hidden transform transition-all duration-300 hover:shadow-xl">
                <div class="card-header-green">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Datos Físicos
                    </h3>
                </div>
                <div class="p-6 space-y-5">

                    <!-- Fecha de Nacimiento -->
                    <div>
                        <label for="fecha_nacimiento" class="block text-sm font-semibold text-gray-700 mb-2">
                            Fecha de Nacimiento
                        </label>
                        <input 
                            type="date" 
                            name="fecha_nacimiento" 
                            id="fecha_nacimiento"
                            value="{{ old('fecha_nacimiento') }}"
                            class="input-bovi w-full @error('fecha_nacimiento') border-red-500 bg-red-50 @enderror"
                        >
                        @error('fecha_nacimiento')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Opcional</p>
                    </div>

                    <!-- Peso Aproximado -->
                    <div>
                        <label for="peso_aproximado" class="block text-sm font-semibold text-gray-700 mb-2">
                            Peso Aproximado (kg)
                        </label>
                        <input 
                            type="number" 
                            name="peso_aproximado" 
                            id="peso_aproximado"
                            value="{{ old('peso_aproximado') }}"
                            placeholder="Ej: 450.50"
                            step="0.01"
                            min="0"
                            class="input-bovi w-full @error('peso_aproximado') border-red-500 bg-red-50 @enderror"
                        >
                        @error('peso_aproximado')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Opcional</p>
                    </div>

                    <!-- Color -->
                    <div>
                        <label for="color" class="block text-sm font-semibold text-gray-700 mb-2">
                            Color
                        </label>
                        <input 
                            type="text" 
                            name="color" 
                            id="color"
                            value="{{ old('color') }}"
                            placeholder="Ej: Rojo, Blanco y Negro, Gris"
                            class="input-bovi w-full @error('color') border-red-500 bg-red-50 @enderror"
                        >
                        @error('color')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Opcional</p>
                    </div>

                </div>
            </div>

            <!-- Sección: Información Adicional -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-6 overflow-hidden transform transition-all duration-300 hover:shadow-xl">
                <div class="card-header-brown">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Información Adicional
                    </h3>
                </div>
                <div class="p-6">

                    <!-- Observaciones -->
                    <div>
                        <label for="observaciones" class="block text-sm font-semibold text-gray-700 mb-2">
                            Observaciones
                        </label>
                        <textarea 
                            name="observaciones" 
                            id="observaciones"
                            placeholder="Ingrese notas adicionales sobre el animal (vacunas, tratamientos, etc.)"
                            rows="4"
                            class="input-bovi w-full @error('observaciones') border-red-500 bg-red-50 @enderror"
                        >{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Opcional</p>
                    </div>

                </div>
            </div>

            <!-- Sección: Imágenes -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-6 overflow-hidden transform transition-all duration-300 hover:shadow-xl">
                <div class="card-header-amber">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Imágenes
                    </h3>
                </div>
                <div class="p-6 space-y-5">

                    <!-- Foto de la Boca -->
                    <div>
                        <label for="foto_boca" class="block text-sm font-semibold text-gray-700 mb-2">
                            Foto de la Boca <span class="text-red-600">*</span>
                        </label>
                        <input 
                            type="file" 
                            name="foto_boca" 
                            id="foto_boca"
                            accept="image/*"
                            class="file-input-bovi w-full @error('foto_boca') border-red-500 bg-red-50 @enderror"
                            required
                        >
                        @error('foto_boca')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Requerida. Máximo 10MB. Formato: JPG, PNG, etc.</p>
                    </div>

                    <!-- Foto General -->
                    <div>
                        <label for="foto_general" class="block text-sm font-semibold text-gray-700 mb-2">
                            Foto General
                        </label>
                        <input 
                            type="file" 
                            name="foto_general" 
                            id="foto_general"
                            accept="image/*"
                            class="file-input-bovi w-full @error('foto_general') border-red-500 bg-red-50 @enderror"
                        >
                        @error('foto_general')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Opcional. Máximo 10MB por foto. Foto del animal completo.</p>
                    </div>

                    <!-- Fotos Adicionales -->
                    <div>
                        <label for="fotos_adicionales" class="block text-sm font-semibold text-gray-700 mb-2">
                            Fotos Adicionales
                        </label>
                        <input 
                            type="file" 
                            name="fotos_adicionales[]" 
                            id="fotos_adicionales"
                            accept="image/*"
                            multiple
                            class="file-input-bovi w-full @error('fotos_adicionales') border-red-500 bg-red-50 @enderror"
                        >
                        @error('fotos_adicionales.*')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Opcional. Máximo 10MB por foto. Puedes subir múltiples imágenes.</p>
                    </div>

                </div>
            </div>

            <!-- Botones -->
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
                <button type="submit" class="btn-bovi-gradient flex-1 py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center gap-2" id="submitBtn">
                    <span id="submitText" class="flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Guardar Ganado
                    </span>
                    <span id="submitSpinner" class="hidden flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Guardando...
                    </span>
                </button>
                <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 px-6 rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Panel
                </a>
            </div>

            <!-- Leyenda -->
            <div class="rounded-lg p-4 border-l-4 bg-bovi-green-50 border-l-bovi-green-800">
                <p class="text-sm text-gray-700 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-bovi-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-red-600 font-bold mr-1">*</span> = Campo requerido
                </p>
            </div>

        </form>

    </div>

    <style>
        /* Estilo personalizado para botones de carga de archivos */
        input[type="file"]::file-selector-button {
            background: linear-gradient(to right, #d97706, #b45309);
            color: white;
            font-weight: 600;
        }
        input[type="file"]::file-selector-button:hover {
            background: linear-gradient(to right, #b45309, #92400e);
        }
    </style>

    <script>
        // Mostrar spinner al enviar el formulario
        document.getElementById('ganadoForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitSpinner = document.getElementById('submitSpinner');
            
            // Deshabilitar botón y mostrar spinner
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            submitText.classList.add('hidden');
            submitSpinner.classList.remove('hidden');
        });

        // Previsualización de imágenes
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function(e) {
                const files = e.target.files;
                if (files.length > 0) {
                    const fileNames = Array.from(files).map(f => f.name).join(', ');
                    console.log('Archivos seleccionados:', fileNames);
                    
                    // Validar tamaño de archivos (10MB máximo)
                    Array.from(files).forEach(file => {
                        if (file.size > 10 * 1024 * 1024) {
                            alert(`El archivo ${file.name} excede el tamaño máximo de 10MB`);
                            e.target.value = '';
                        }
                    });
                }
            });
        });

        // Animación de entrada para las secciones
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '0';
                    entry.target.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        entry.target.style.transition = 'all 0.5s ease-out';
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, 100);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.bg-white.rounded-xl').forEach(section => {
            observer.observe(section);
        });
    </script>

</x-app-layout>
