{{--
    Partial: resources/views/admin/reproductivo/_form.blade.php
    Variables esperadas:
      - $animal       : Animal
      - $record       : AnimalReproductiveRecord (puede ser new AnimalReproductiveRecord())
      - $tiposProceso : array (AnimalReproductiveRecord::TIPOS_PROCESO)
      - $action       : URL del formulario
      - $method       : 'POST' | 'PUT'
--}}

<form method="POST" action="{{ $action }}" id="reproductivoForm">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    {{-- ══════════════════════════════════════════════════════════ --}}
    {{-- SECCIÓN 1: Palpación                                      --}}
    {{-- ══════════════════════════════════════════════════════════ --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-green-100 text-green-700 text-xs font-bold shrink-0">1</div>
            <h4 class="text-base font-bold text-green-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Palpación del Animal
            </h4>
        </div>

        <div class="bg-green-50 rounded-xl p-5 space-y-4 border border-green-100">

            {{-- Toggle palpación realizada --}}
            <div class="flex items-center gap-4">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input
                        type="checkbox"
                        name="palpacion"
                        id="palpacion"
                        value="1"
                        class="sr-only peer"
                        {{ old('palpacion', $record->palpacion ?? false) ? 'checked' : '' }}
                        onchange="togglePalpacion(this.checked)"
                    >
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                    <span class="ml-3 text-sm font-semibold text-gray-700">Palpación realizada</span>
                </label>
            </div>

            {{-- Campos que aparecen al activar palpación --}}
            <div id="palpacion_fields" class="{{ old('palpacion', $record->palpacion ?? false) ? '' : 'hidden' }} space-y-4">

                {{-- Fecha de palpación --}}
                <div>
                    <label for="fecha_palpacion" class="block text-sm font-semibold text-gray-700 mb-2">
                        Fecha de Palpación <span class="text-red-600">*</span>
                    </label>
                    <input
                        type="date"
                        name="fecha_palpacion"
                        id="fecha_palpacion"
                        value="{{ old('fecha_palpacion', isset($record->fecha_palpacion) ? $record->fecha_palpacion->format('Y-m-d') : '') }}"
                        max="{{ date('Y-m-d') }}"
                        class="input-bovi w-full @error('fecha_palpacion') border-red-500 bg-red-50 @enderror"
                    >
                    @error('fecha_palpacion')
                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Observaciones de palpación --}}
                <div>
                    <label for="observaciones_palpacion" class="block text-sm font-semibold text-gray-700 mb-2">
                        Observaciones de la Palpación
                    </label>
                    <textarea
                        name="observaciones_palpacion"
                        id="observaciones_palpacion"
                        rows="2"
                        placeholder="Resultado de la palpación, condición del animal..."
                        class="input-bovi w-full @error('observaciones_palpacion') border-red-500 bg-red-50 @enderror"
                    >{{ old('observaciones_palpacion', $record->observaciones_palpacion ?? '') }}</textarea>
                    @error('observaciones_palpacion')
                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════ --}}
    {{-- SECCIÓN 2: Dosis Reproductiva                             --}}
    {{-- ══════════════════════════════════════════════════════════ --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-purple-100 text-purple-700 text-xs font-bold shrink-0">2</div>
            <h4 class="text-base font-bold text-purple-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
                Dosis para Acelerar Ciclo Reproductivo
            </h4>
        </div>

        <div class="bg-purple-50 rounded-xl p-5 space-y-4 border border-purple-100">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Dosis --}}
                <div>
                    <label for="dosis_reproductiva" class="block text-sm font-semibold text-gray-700 mb-2">
                        Dosis Aplicada
                    </label>
                    <input
                        type="text"
                        name="dosis_reproductiva"
                        id="dosis_reproductiva"
                        value="{{ old('dosis_reproductiva', $record->dosis_reproductiva ?? '') }}"
                        placeholder="Ej: GnRH 2ml, PGF2α 5ml..."
                        class="input-bovi w-full @error('dosis_reproductiva') border-red-500 bg-red-50 @enderror"
                    >
                    @error('dosis_reproductiva')
                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Opcional.</p>
                </div>

                {{-- Fecha de aplicación --}}
                <div>
                    <label for="fecha_dosis" class="block text-sm font-semibold text-gray-700 mb-2">
                        Fecha de Aplicación
                    </label>
                    <input
                        type="date"
                        name="fecha_dosis"
                        id="fecha_dosis"
                        value="{{ old('fecha_dosis', isset($record->fecha_dosis) ? $record->fecha_dosis->format('Y-m-d') : '') }}"
                        max="{{ date('Y-m-d') }}"
                        class="input-bovi w-full @error('fecha_dosis') border-red-500 bg-red-50 @enderror"
                    >
                    @error('fecha_dosis')
                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Opcional. No puede ser futura.</p>
                </div>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════ --}}
    {{-- SECCIÓN 3: Proceso Reproductivo y Preñez                  --}}
    {{-- ══════════════════════════════════════════════════════════ --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-rose-100 text-rose-700 text-xs font-bold shrink-0">3</div>
            <h4 class="text-base font-bold text-rose-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                Proceso Reproductivo y Preñez
            </h4>
        </div>

        <div class="bg-rose-50 rounded-xl p-5 space-y-4 border border-rose-100">

            {{-- Tipo de proceso --}}
            <div>
                <label for="tipo_proceso" class="block text-sm font-semibold text-gray-700 mb-2">
                    Tipo de Proceso Reproductivo
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3" id="tipo_proceso_group">
                    @foreach($tiposProceso as $valor => $etiqueta)
                        <label class="relative cursor-pointer">
                            <input
                                type="radio"
                                name="tipo_proceso"
                                value="{{ $valor }}"
                                class="sr-only peer"
                                {{ old('tipo_proceso', $record->tipo_proceso ?? '') === $valor ? 'checked' : '' }}
                            >
                            <div class="flex items-center justify-center px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-sm font-semibold text-gray-600
                                        peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-700
                                        hover:border-rose-300 transition-all duration-150 text-center">
                                @if($valor === 'embrion')
                                    🧬
                                @elseif($valor === 'inseminacion')
                                    💉
                                @else
                                    🐄
                                @endif
                                <span class="ml-1.5">{{ $etiqueta }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('tipo_proceso')
                    <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Opcional.</p>
            </div>

            {{-- Fecha de inserción (monta / inseminación / embrión) --}}
            <div>
                <label for="fecha_insercion" class="block text-sm font-semibold text-gray-700 mb-2">
                    Fecha de Inserción / Monta
                </label>
                <input
                    type="date"
                    name="fecha_insercion"
                    id="fecha_insercion"
                    value="{{ old('fecha_insercion', isset($record->fecha_insercion) ? $record->fecha_insercion->format('Y-m-d') : '') }}"
                    max="{{ date('Y-m-d') }}"
                    class="input-bovi w-full @error('fecha_insercion') border-red-500 bg-red-50 @enderror"
                >
                @error('fecha_insercion')
                    <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Registra la fecha de inserción del semen/embrión o la monta.</p>
            </div>

            {{-- Fecha de preñez --}}
            <div>
                <label for="fecha_prenez" class="block text-sm font-semibold text-gray-700 mb-2">
                    Fecha de Preñez
                </label>
                <input
                    type="date"
                    name="fecha_prenez"
                    id="fecha_prenez"
                    value="{{ old('fecha_prenez', isset($record->fecha_prenez) ? $record->fecha_prenez->format('Y-m-d') : '') }}"
                    max="{{ date('Y-m-d') }}"
                    class="input-bovi w-full @error('fecha_prenez') border-red-500 bg-red-50 @enderror"
                    onchange="calcularParto()"
                >
                @error('fecha_prenez')
                    <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Opcional. No puede ser futura.</p>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════ --}}
    {{-- SECCIÓN 4: Nacimiento Estimado                            --}}
    {{-- ══════════════════════════════════════════════════════════ --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-amber-100 text-amber-700 text-xs font-bold shrink-0">4</div>
            <h4 class="text-base font-bold text-amber-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Fecha Estimada de Nacimiento de la Cría
            </h4>
        </div>

        <div class="bg-amber-50 rounded-xl p-5 border border-amber-100">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-end">
                <div>
                    <label for="fecha_estimada_parto" class="block text-sm font-semibold text-gray-700 mb-2">
                        Fecha Estimada de Parto
                    </label>
                    <input
                        type="date"
                        name="fecha_estimada_parto"
                        id="fecha_estimada_parto"
                        value="{{ old('fecha_estimada_parto', isset($record->fecha_estimada_parto) ? $record->fecha_estimada_parto->format('Y-m-d') : '') }}"
                        class="input-bovi w-full @error('fecha_estimada_parto') border-red-500 bg-red-50 @enderror"
                    >
                    @error('fecha_estimada_parto')
                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Debe ser posterior a la fecha de preñez.</p>
                </div>

                {{-- Calculadora rápida --}}
                <div>
                    <p class="text-xs font-semibold text-gray-600 mb-2">Calcular automáticamente</p>
                    <div class="flex gap-2">
                        <button type="button"
                                onclick="calcularParto(283)"
                                class="flex-1 text-xs bg-amber-100 hover:bg-amber-200 text-amber-800 font-semibold px-3 py-2 rounded-lg transition-colors">
                            🐄 +283 días (bovino)
                        </button>
                    </div>
                    <p id="dias_restantes" class="mt-2 text-xs text-amber-700 font-medium hidden"></p>
                </div>
            </div>

        </div>
    </div>

    {{-- ── Observaciones generales ───────────────────────────── --}}
    <div class="mb-6">
        <label for="observaciones" class="block text-sm font-semibold text-gray-700 mb-2">
            Observaciones Generales
        </label>
        <textarea
            name="observaciones"
            id="observaciones"
            rows="3"
            placeholder="Notas adicionales sobre el proceso reproductivo..."
            class="input-bovi w-full @error('observaciones') border-red-500 bg-red-50 @enderror"
        >{{ old('observaciones', $record->observaciones ?? '') }}</textarea>
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

    {{-- ── Re-palpación y confirmación del proceso ───────────── --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold shrink-0">5</div>
            <h4 class="text-base font-bold text-indigo-700 flex items-center gap-2">Re-palpación y Confirmación</h4>
        </div>

        <div class="bg-indigo-50 rounded-xl p-5 space-y-4 border border-indigo-100">
            <div class="flex items-center gap-4">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input
                        type="checkbox"
                        name="repalpacion"
                        id="repalpacion"
                        value="1"
                        class="sr-only peer"
                        {{ old('repalpacion', $record->repalpacion ?? false) ? 'checked' : '' }}
                        onchange="toggleRepalpacion(this.checked)"
                    >
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="ml-3 text-sm font-semibold text-gray-700">Re-palpación realizada</span>
                </label>
            </div>

            <div id="repalpacion_fields" class="{{ old('repalpacion', $record->repalpacion ?? false) ? '' : 'hidden' }} space-y-3">
                <div>
                    <label for="fecha_repalpacion" class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Re-palpación</label>
                    <input type="date" name="fecha_repalpacion" id="fecha_repalpacion" max="{{ date('Y-m-d') }}" class="input-bovi w-full" value="{{ old('fecha_repalpacion', isset($record->fecha_repalpacion) ? $record->fecha_repalpacion->format('Y-m-d') : '') }}">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Resultado</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="inline-flex items-center gap-2">
                            <input type="radio" name="repalpacion_efectiva" value="1" {{ old('repalpacion_efectiva', $record->repalpacion_efectiva ?? null) ? 'checked' : '' }}>
                            <span class="text-sm">Efectivo (Confirmado)</span>
                        </label>
                        <label class="inline-flex items-center gap-2">
                            <input type="radio" name="repalpacion_efectiva" value="0" {{ old('repalpacion_efectiva', $record->repalpacion_efectiva ?? null) === 0 ? 'checked' : '' }}>
                            <span class="text-sm">No efectivo</span>
                        </label>
                    </div>
                </div>

                <p class="text-xs text-gray-500">Si la re-palpación confirma embarazo, la fecha estimada de parto se calculará automáticamente si no fue ingresada.</p>
            </div>
        </div>
    </div>

    {{-- ── Botones ─────────────────────────────────────────────── --}}
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
        <a href="{{ route('animals.reproductive.index', $animal) }}"
           class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 px-6 rounded-lg transition-all flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Cancelar
        </a>
    </div>

</form>

<script>
    // ── Toggle sección palpación ─────────────────────────────────
    function togglePalpacion(checked) {
        const fields = document.getElementById('palpacion_fields');
        const fechaInput = document.getElementById('fecha_palpacion');
        if (checked) {
            fields.classList.remove('hidden');
        } else {
            fields.classList.add('hidden');
            fechaInput.value = '';
            document.getElementById('observaciones_palpacion').value = '';
        }
    }

    // ── Calculadora de parto ─────────────────────────────────────
    function calcularParto(dias = null) {
        const fechaPrenez = document.getElementById('fecha_prenez').value;
        const fechaParto  = document.getElementById('fecha_estimada_parto');
        const diasLabel   = document.getElementById('dias_restantes');

        if (!fechaPrenez) {
            alert('Primero ingresa la fecha de preñez.');
            return;
        }

        if (dias !== null) {
            // Calcular fecha desde preñez + días de gestación
            const prenez = new Date(fechaPrenez);
            prenez.setDate(prenez.getDate() + dias);
            fechaParto.value = prenez.toISOString().split('T')[0];
        }

        // Mostrar días restantes si la fecha de parto ya tiene valor
        if (fechaParto.value) {
            const hoy   = new Date();
            const parto = new Date(fechaParto.value);
            const diff  = Math.round((parto - hoy) / (1000 * 60 * 60 * 24));

            diasLabel.classList.remove('hidden');
            if (diff > 0) {
                diasLabel.textContent = `🗓 Faltan aprox. ${diff} días para el parto estimado.`;
                diasLabel.className = 'mt-2 text-xs text-amber-700 font-medium';
            } else if (diff === 0) {
                diasLabel.textContent = '🐄 ¡El parto estimado es hoy!';
                diasLabel.className = 'mt-2 text-xs text-green-700 font-semibold';
            } else {
                diasLabel.textContent = `⚠️ La fecha estimada de parto ya pasó hace ${Math.abs(diff)} días.`;
                diasLabel.className = 'mt-2 text-xs text-red-600 font-medium';
            }
        }
    }

    // Inicializar contador al cargar si ya hay fecha
    document.addEventListener('DOMContentLoaded', function () {
        const parto = document.getElementById('fecha_estimada_parto').value;
        const prenez = document.getElementById('fecha_prenez').value;
        if (parto && prenez) calcularParto();
    });

    // ── Spinner al enviar ────────────────────────────────────────
    document.getElementById('reproductivoForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
    });

    // Toggle re-palpación
    function toggleRepalpacion(checked) {
        const wrap = document.getElementById('repalpacion_fields');
        const fecha = document.getElementById('fecha_repalpacion');
        if (checked) {
            wrap.classList.remove('hidden');
        } else {
            wrap.classList.add('hidden');
            if (fecha) fecha.value = '';
            const radios = document.getElementsByName('repalpacion_efectiva');
            radios.forEach(r => r.checked = false);
        }
    }
</script>