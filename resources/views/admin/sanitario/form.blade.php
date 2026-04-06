{{--
    Partial: resources/views/admin/sanitario/_form.blade.php
    Variables:
      - $animal   : Animal
      - $health   : AnimalHealthRecord (puede ser new AnimalHealthRecord())
      - $action   : URL del formulario
      - $method   : 'POST' | 'PUT'
--}}

<form method="POST" action="{{ $action }}" id="sanitarioForm">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    {{-- Error de sección vacía (validación manual) --}}
    @error('seccion')
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6 flex items-center gap-3">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <p class="text-sm text-red-700 font-medium">{{ $message }}</p>
        </div>
    @enderror

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- SECCIÓN 1: Lavado Antiparasitario                     --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-blue-100 text-blue-700 text-xs font-bold shrink-0">1</div>
            <h4 class="text-base font-bold text-blue-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
                Lavado Antiparasitario
            </h4>
        </div>

        <div class="bg-blue-50 rounded-xl p-5 space-y-4 border border-blue-100">

            {{-- Fecha de lavado --}}
            <div>
                <label for="fecha_lavado" class="block text-sm font-semibold text-gray-700 mb-2">
                    Fecha de Lavado
                </label>
                <input
                    type="date"
                    name="fecha_lavado"
                    id="fecha_lavado"
                    value="{{ old('fecha_lavado', isset($health->fecha_lavado) ? $health->fecha_lavado->format('Y-m-d') : '') }}"
                    max="{{ date('Y-m-d') }}"
                    class="input-bovi w-full @error('fecha_lavado') border-red-500 bg-red-50 @enderror"
                >
                @error('fecha_lavado')
                    <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Opcional. No puede ser fecha futura.</p>
            </div>

            {{-- Producto del lavado --}}
            <div>
                <label for="producto_lavado" class="block text-sm font-semibold text-gray-700 mb-2">
                    Producto Utilizado
                </label>
                <input
                    type="text"
                    name="producto_lavado"
                    id="producto_lavado"
                    value="{{ old('producto_lavado', $health->producto_lavado ?? '') }}"
                    placeholder="Ej: Cipermetrina, Amitraz, Deltametrina..."
                    class="input-bovi w-full @error('producto_lavado') border-red-500 bg-red-50 @enderror"
                >
                @error('producto_lavado')
                    <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Requerido si ingresaste fecha de lavado.</p>

                {{-- Opción para agregar otro producto --}}
                <div class="mt-3">
                    <button type="button" id="toggleOtroProducto" class="text-sm text-blue-600 hover:underline">Agregar otro producto</button>
                </div>

                <div id="otroProductoWrap" class="mt-3 hidden">
                    <label for="producto_lavado_secundario" class="block text-sm font-semibold text-gray-700 mb-2">Otro Producto (opcional)</label>
                    <input
                        type="text"
                        name="producto_lavado_secundario"
                        id="producto_lavado_secundario"
                        value="{{ old('producto_lavado_secundario', $health->producto_lavado_secundario ?? '') }}"
                        placeholder="Ej: Amitraz (mezcla)"
                        class="input-bovi w-full @error('producto_lavado_secundario') border-red-500 bg-red-50 @enderror"
                    >
                    @error('producto_lavado_secundario')
                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Opcional. Completa sólo si aplicaste un segundo producto.</p>
                </div>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- SECCIÓN 2: Purgas                                     --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-amber-100 text-amber-700 text-xs font-bold shrink-0">2</div>
            <h4 class="text-base font-bold text-amber-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Purgas
            </h4>
        </div>

        <div class="bg-amber-50 rounded-xl p-5 space-y-4 border border-amber-100">

            {{-- Fecha de purga --}}
            <div>
                <label for="fecha_purga" class="block text-sm font-semibold text-gray-700 mb-2">
                    Fecha de Purga
                </label>
                <input
                    type="date"
                    name="fecha_purga"
                    id="fecha_purga"
                    value="{{ old('fecha_purga', isset($health->fecha_purga) ? $health->fecha_purga->format('Y-m-d') : '') }}"
                    max="{{ date('Y-m-d') }}"
                    class="input-bovi w-full @error('fecha_purga') border-red-500 bg-red-50 @enderror"
                >
                @error('fecha_purga')
                    <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Opcional. No puede ser fecha futura.</p>
            </div>

            {{-- Tipo de purgante --}}
            <div>
                <label for="tipo_purgante" class="block text-sm font-semibold text-gray-700 mb-2">
                    Tipo de Purgante
                </label>
                <input
                    type="text"
                    name="tipo_purgante"
                    id="tipo_purgante"
                    value="{{ old('tipo_purgante', $health->tipo_purgante ?? '') }}"
                    placeholder="Ej: Albendazol, Ivermectina, Levamisol..."
                    class="input-bovi w-full @error('tipo_purgante') border-red-500 bg-red-50 @enderror"
                >
                @error('tipo_purgante')
                    <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Requerido si ingresaste fecha de purga.</p>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- Observaciones generales                               --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div class="mb-6">
        <label for="observaciones" class="block text-sm font-semibold text-gray-700 mb-2">
            Observaciones Generales
        </label>
        <textarea
            name="observaciones"
            id="observaciones"
            rows="3"
            placeholder="Notas adicionales sobre el procedimiento sanitario..."
            class="input-bovi w-full @error('observaciones') border-red-500 bg-red-50 @enderror"
        >{{ old('observaciones', $health->observaciones ?? '') }}</textarea>
        @error('observaciones')
            <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $message }}
            </p>
        @enderror
        <p class="mt-1 text-xs text-gray-500">Opcional. Máximo 1000 caracteres.</p>
    </div>

    {{-- ── Botones ─────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row gap-4">
        <button
            type="submit"
            id="submitBtn"
            class="btn-bovi-gradient flex-1 py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center gap-2 font-bold"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ $method === 'PUT' ? 'Actualizar Registro' : 'Guardar Registro' }}
        </button>
        <a href="{{ route('animals.health.index', $animal) }}"
           class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 px-6 rounded-lg transition-all flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Cancelar
        </a>
    </div>

</form>

<script>
    document.getElementById('sanitarioForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
    });

    // Toggle para mostrar el campo de producto secundario
    (function () {
        const toggle = document.getElementById('toggleOtroProducto');
        const wrap = document.getElementById('otroProductoWrap');
        if (!toggle || !wrap) return;

        // Mostrar si ya existe valor
        const existing = document.getElementById('producto_lavado_secundario') && document.getElementById('producto_lavado_secundario').value.trim() !== '';
        if (existing) wrap.classList.remove('hidden');

        toggle.addEventListener('click', function () {
            wrap.classList.toggle('hidden');
        });
    })();
</script>