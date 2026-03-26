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

            <!-- ═══════════════════════════════════════════════════ -->
            <!-- Sección: Información Básica                        -->
            <!-- ═══════════════════════════════════════════════════ -->
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

                    <!-- ══════════════════════════════════════════════ -->
                    <!-- NUEVO: Raza como dropdown + campo "Otra raza" -->
                    <!-- ══════════════════════════════════════════════ -->
                    <div>
                        <label for="raza" class="block text-sm font-semibold text-gray-700 mb-2">
                            Raza (Cruce Reproductivo) <span class="text-red-600">*</span>
                        </label>
                        <select 
                            name="raza_select" 
                            id="raza_select"
                            class="input-bovi w-full @error('raza') border-red-500 bg-red-50 @enderror"
                            onchange="toggleOtraRaza(this.value)"
                            required
                        >
                            <option value="">-- Seleccione una raza --</option>
                            <option value="Gyrolando 3/4"   {{ old('raza') == 'Gyrolando 3/4'   ? 'selected' : '' }}>Gyrolando ¾</option>
                            <option value="Gyrolando 5/8"   {{ old('raza') == 'Gyrolando 5/8'   ? 'selected' : '' }}>Gyrolando 5/8</option>
                            <option value="F1"              {{ old('raza') == 'F1'              ? 'selected' : '' }}>F1</option>
                            <option value="Brahman"         {{ old('raza') == 'Brahman'         ? 'selected' : '' }}>Brahman</option>
                            <option value="Angus"           {{ old('raza') == 'Angus'           ? 'selected' : '' }}>Angus</option>
                            <option value="Nelore"          {{ old('raza') == 'Nelore'          ? 'selected' : '' }}>Nelore</option>
                            <option value="Simmental"       {{ old('raza') == 'Simmental'       ? 'selected' : '' }}>Simmental</option>
                            <option value="Cebu"            {{ old('raza') == 'Cebu'            ? 'selected' : '' }}>Cebú</option>
                            <option value="otra"            {{ (old('raza') && !in_array(old('raza'), ['Gyrolando 3/4','Gyrolando 5/8','F1','Brahman','Angus','Nelore','Simmental','Cebu'])) ? 'selected' : '' }}>Otra raza...</option>
                        </select>

                        <!-- Campo de texto que aparece solo cuando se selecciona "Otra raza" -->
                        <div id="otra_raza_container" class="mt-3 {{ (old('raza') && !in_array(old('raza'), ['Gyrolando 3/4','Gyrolando 5/8','F1','Brahman','Angus','Nelore','Simmental','Cebu'])) ? '' : 'hidden' }}">
                            <input 
                                type="text" 
                                name="raza" 
                                id="raza"
                                value="{{ old('raza') }}"
                                placeholder="Escriba la raza del animal"
                                class="input-bovi w-full @error('raza') border-red-500 bg-red-50 @enderror"
                            >
                            <p class="mt-1 text-xs text-gray-500">Ingrese el nombre de la raza</p>
                        </div>

                        <!-- Campo oculto que se completa cuando se elige del dropdown (no "otra") -->
                        <input type="hidden" name="raza" id="raza_hidden" value="{{ old('raza') }}">

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
                            <option value="macho"  {{ old('sexo') == 'macho'  ? 'selected' : '' }}>Macho</option>
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

                    <!-- ══════════════════════════════════════════════ -->
                    <!-- NUEVO: Propósito del animal                   -->
                    <!-- ══════════════════════════════════════════════ -->
                    <div>
                        <label for="proposito" class="block text-sm font-semibold text-gray-700 mb-2">
                            Propósito <span class="text-red-600">*</span>
                        </label>
                        <select 
                            name="proposito" 
                            id="proposito"
                            class="input-bovi w-full @error('proposito') border-red-500 bg-red-50 @enderror"
                            required
                        >
                            <option value="">-- Seleccione el propósito --</option>
                            <option value="carne"          {{ old('proposito') == 'carne'          ? 'selected' : '' }}>🥩 Carne</option>
                            <option value="leche"          {{ old('proposito') == 'leche'          ? 'selected' : '' }}>🥛 Leche</option>
                            <option value="doble_proposito" {{ old('proposito') == 'doble_proposito' ? 'selected' : '' }}>⚡ Doble Propósito</option>
                        </select>
                        @error('proposito')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Requerido</p>
                    </div>

                    <!-- ══════════════════════════════════════════════ -->
                    <!-- NUEVO: Estado del animal                      -->
                    <!-- ══════════════════════════════════════════════ -->
                    <div>
                        <label for="estado" class="block text-sm font-semibold text-gray-700 mb-2">
                            Estado del Animal <span class="text-red-600">*</span>
                        </label>
                        <select 
                            name="estado" 
                            id="estado"
                            class="input-bovi w-full @error('estado') border-red-500 bg-red-50 @enderror"
                            required
                        >
                            <option value="">-- Seleccione el estado --</option>
                            <option value="activo"  {{ old('estado', 'activo') == 'activo'  ? 'selected' : '' }}>✅ Activo</option>
                            <option value="vendido" {{ old('estado') == 'vendido' ? 'selected' : '' }}>💰 Vendido</option>
                            <option value="muerto"  {{ old('estado') == 'muerto'  ? 'selected' : '' }}>❌ Muerto</option>
                        </select>
                        @error('estado')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Requerido. Por defecto: Activo</p>
                    </div>

                </div>
            </div>

            <!-- ═══════════════════════════════════════════════════ -->
            <!-- Sección: Datos Físicos                             -->
            <!-- ═══════════════════════════════════════════════════ -->
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

                    <!-- ══════════════════════════════════════════════════════════════════ -->
                    <!-- MODIFICADO: Dos campos de fecha separados en lugar de uno solo   -->
                    <!-- ══════════════════════════════════════════════════════════════════ -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
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

                        <!-- NUEVO: Fecha de Ingreso al Hato -->
                        <div>
                            <label for="fecha_ingreso_hato" class="block text-sm font-semibold text-gray-700 mb-2">
                                Fecha de Ingreso al Hato
                            </label>
                            <input 
                                type="date" 
                                name="fecha_ingreso_hato" 
                                id="fecha_ingreso_hato"
                                value="{{ old('fecha_ingreso_hato', date('Y-m-d')) }}"
                                class="input-bovi w-full @error('fecha_ingreso_hato') border-red-500 bg-red-50 @enderror"
                            >
                            @error('fecha_ingreso_hato')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Opcional. Por defecto: hoy</p>
                        </div>
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

            <!-- ═══════════════════════════════════════════════════ -->
            <!-- Sección: Información Adicional                     -->
            <!-- ═══════════════════════════════════════════════════ -->
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

            <!-- ═══════════════════════════════════════════════════ -->
            <!-- Sección: Imágenes                                  -->
            <!-- ═══════════════════════════════════════════════════ -->
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
                        <p class="mt-1 text-xs text-gray-500">Opcional. Máximo 10MB. Foto del animal completo.</p>
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
                <a href="{{ route('ganado.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 px-6 rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
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
        // ──────────────────────────────────────────────
        // Lógica del dropdown de Raza + "Otra raza"
        // ──────────────────────────────────────────────
        function toggleOtraRaza(value) {
            const otraContainer = document.getElementById('otra_raza_container');
            const razaInput     = document.getElementById('raza');
            const razaHidden    = document.getElementById('raza_hidden');

            if (value === 'otra') {
                // Mostrar campo de texto libre, limpiar hidden
                otraContainer.classList.remove('hidden');
                razaInput.required = true;
                razaHidden.name    = '';      // Desactivar el hidden para que no envíe valor vacío
                razaInput.name     = 'raza';  // Activar el campo de texto como el que envía "raza"
                razaInput.focus();
            } else {
                // Ocultar campo de texto, enviar valor del dropdown por hidden
                otraContainer.classList.add('hidden');
                razaInput.required = false;
                razaInput.name     = '';      // Desactivar el campo de texto
                razaHidden.name    = 'raza';  // Activar el hidden
                razaHidden.value   = value;
            }
        }

        // Inicializar al cargar (por si hay old() con "otra raza")
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('raza_select');
            if (select.value) {
                toggleOtraRaza(select.value);
            }
        });

        // ──────────────────────────────────────────────
        // Spinner al enviar
        // ──────────────────────────────────────────────
        document.getElementById('ganadoForm').addEventListener('submit', function(e) {
            const submitBtn    = document.getElementById('submitBtn');
            const submitText   = document.getElementById('submitText');
            const submitSpinner = document.getElementById('submitSpinner');

            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            submitText.classList.add('hidden');
            submitSpinner.classList.remove('hidden');
        });

        // ──────────────────────────────────────────────
        // Validación de tamaño de archivos (10MB)
        // ──────────────────────────────────────────────
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function(e) {
                Array.from(e.target.files).forEach(file => {
                    if (file.size > 10 * 1024 * 1024) {
                        alert(`El archivo "${file.name}" excede el tamaño máximo de 10MB.`);
                        e.target.value = '';
                    }
                });
            });
        });

        // ──────────────────────────────────────────────
        // Animación de entrada para las secciones
        // ──────────────────────────────────────────────
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
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        document.querySelectorAll('.bg-white.rounded-xl').forEach(section => {
            observer.observe(section);
        });
    </script>

</x-app-layout>