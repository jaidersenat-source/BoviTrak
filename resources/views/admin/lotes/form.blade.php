{{--
    Partial: resources/views/admin/lotes/form.blade.php
    Variables esperadas:
      - $lote   : App\Models\Lotes (puede ser new App\Models\Lotes())
      - $action : URL del formulario
      - $method : 'POST' | 'PUT'
--}}

@php $isEdit = isset($lote) && $lote->exists; @endphp

<form method="POST" action="{{ $action }}" id="loteForm" class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-5">
    @csrf
    @if($isEdit) @method('PUT') @endif

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-900 tracking-tight">
                {{ $isEdit ? 'Editar lote' : 'Nuevo lote' }}
            </h2>
            @if($isEdit)
                <p class="text-sm text-gray-500 mt-0.5">Código: <span class="font-medium text-gray-700">{{ $lote->codigo }}</span></p>
            @endif
        </div>
        <a href="{{ route('admin.lotes.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 bg-white border border-gray-200 hover:border-gray-300 px-3.5 py-2 rounded-lg transition-all duration-150">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver
        </a>
    </div>

    {{-- Errores --}}
    @if($errors->any())
        <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3.5">
            <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-sm font-medium text-red-800 mb-1">Corrige los siguientes errores:</p>
                <ul class="text-xs text-red-700 space-y-0.5 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- ── Sección 1: Identificación ── --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <div class="flex items-center gap-2.5 px-5 py-4 border-b border-gray-100">
            <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z"/>
                </svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-800">Identificación</h3>
        </div>
        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

            {{-- Código --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Código <span class="text-red-500">*</span>
                </label>
                <input type="text" name="codigo" required
                       value="{{ old('codigo', $lote->codigo ?? '') }}"
                       placeholder="Ej: L-01"
                       class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white transition-all
                              @error('codigo') border-red-400 bg-red-50 @enderror">
                @error('codigo')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Área --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Área (ha)</label>
                <input type="number" name="area_ha" min="0" step="0.01"
                       value="{{ old('area_ha', $lote->area_ha ?? '') }}"
                       placeholder="Ej: 2.50"
                       class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white transition-all">
            </div>

            {{-- Nombre pastura --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Nombre de la pastura</label>
                <input type="text" name="nombre_pastura"
                       value="{{ old('nombre_pastura', $lote->nombre_pastura ?? '') }}"
                       placeholder="Ej: Brachiaria"
                       class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white transition-all">
            </div>

            {{-- Registrado por --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Registrado por</label>
                <input type="text" value="{{ auth()->user()->name ?? '' }}" readonly
                       class="w-full rounded-xl border border-gray-200 bg-gray-100 px-3.5 py-2.5 text-sm text-gray-500 cursor-not-allowed">
            </div>

            {{-- Banco nutricional --}}
            <div class="sm:col-span-2">
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Banco nutricional</label>
                <textarea name="banco_nutricional" rows="2"
                          placeholder="Descripción del banco nutricional disponible…"
                          class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 resize-none
                                 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white transition-all">{{ old('banco_nutricional', $lote->banco_nutricional ?? '') }}</textarea>
            </div>

        </div>
    </div>

    {{-- ── Sección 2: Rotación ── --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <div class="flex items-center gap-2.5 px-5 py-4 border-b border-gray-100">
            <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-800">Rotación y ocupación</h3>
        </div>
        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

            {{-- Tiempo ocupación --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Tiempo de ocupación (días)</label>
                <input type="number" name="tiempo_ocupacion_dias" min="0" step="1"
                       value="{{ old('tiempo_ocupacion_dias', $lote->tiempo_ocupacion_dias ?? '') }}"
                       placeholder="Ej: 7"
                       class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all">
            </div>

            {{-- Tiempo descanso --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Tiempo de descanso (días)</label>
                <input type="number" name="tiempo_descanso_dias" min="0" step="1"
                       value="{{ old('tiempo_descanso_dias', $lote->tiempo_descanso_dias ?? '') }}"
                       placeholder="Ej: 35"
                       class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all">
            </div>

            {{-- Fecha rocería --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Fecha de rocería</label>
                <input type="date" name="fecha_roceria" id="fecha_roceria"
                       value="{{ old('fecha_roceria', isset($lote->fecha_roceria) ? $lote->fecha_roceria->format('Y-m-d') : '') }}"
                       class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all">
                <p class="mt-1.5 text-xs text-gray-400">Usada para calcular el tiempo de descanso.</p>
            </div>

            {{-- Fecha inicio ocupación --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Fecha inicio de ocupación</label>
                <input type="date" name="fecha_inicio_ocupacion" id="fecha_inicio_ocupacion"
                       value="{{ old('fecha_inicio_ocupacion', isset($lote->fecha_inicio_ocupacion) ? $lote->fecha_inicio_ocupacion->format('Y-m-d') : '') }}"
                       class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all">
                <p class="mt-1.5 text-xs text-gray-400">Fecha en que los animales ingresaron al lote.</p>
            </div>

            {{-- Jornales --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Jornales</label>
                <input type="number" name="jornales" min="0" step="1"
                       value="{{ old('jornales', $lote->jornales ?? '') }}"
                       placeholder="Ej: 3"
                       class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all">
                <p class="mt-1.5 text-xs text-gray-400">Jornales aplicados después de la rocería (opcional).</p>
            </div>

        </div>
    </div>

    {{-- ── Sección 3: Mantenimiento ── --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <div class="flex items-center gap-2.5 px-5 py-4 border-b border-gray-100">
            <div class="w-7 h-7 rounded-lg bg-amber-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                </svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-800">Mantenimiento</h3>
        </div>
        <div class="p-5 space-y-4">

            {{-- Aplicación de abonos --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Aplicación de abonos</label>
                <textarea name="aplicacion_abonos" rows="2"
                          placeholder="Tipo de abono, dosis, fecha de aplicación…"
                          class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 resize-none
                                 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent focus:bg-white transition-all">{{ old('aplicacion_abonos', $lote->aplicacion_abonos ?? '') }}</textarea>
            </div>

            {{-- Observaciones --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Observaciones <span class="text-gray-400 font-normal">(opcional)</span>
                </label>
                <textarea name="observaciones" rows="3"
                          placeholder="Notas adicionales sobre el lote…"
                          class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 resize-none
                                 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent focus:bg-white transition-all">{{ old('observaciones', $lote->observaciones ?? '') }}</textarea>
            </div>

        </div>
    </div>

    {{-- ── Acciones ── --}}
    <div class="flex flex-wrap items-center gap-3">
        <button type="submit" id="submitLote"
            class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors duration-150 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ $isEdit ? 'Actualizar lote' : 'Crear lote' }}
        </button>

        <button type="button" id="initOcupacionToday"
            class="inline-flex items-center gap-2 text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 px-5 py-2.5 rounded-xl transition-colors duration-150">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Iniciar ocupación hoy
        </button>

        <a href="{{ route('admin.lotes.index') }}"
           class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 bg-white border border-gray-200 hover:border-gray-300 px-5 py-2.5 rounded-xl transition-all">
            Cancelar
        </a>
    </div>

</form>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // Deshabilitar botón al enviar
    document.getElementById('loteForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitLote');
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
        btn.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            Guardando…`;
    });

    // Validación inline del código
    document.querySelector('input[name="codigo"]').addEventListener('input', function () {
        this.classList.toggle('border-red-400', !this.value.trim());
        this.classList.toggle('ring-2',          !this.value.trim());
        this.classList.toggle('ring-red-300',    !this.value.trim());
    });

    // Iniciar ocupación hoy
    document.getElementById('initOcupacionToday').addEventListener('click', () => {
        if (!confirm('¿Iniciar ocupación hoy? Esto establecerá las fechas y enviará el formulario.')) return;
        const today = new Date();
        const iso   = [
            today.getFullYear(),
            String(today.getMonth() + 1).padStart(2, '0'),
            String(today.getDate()).padStart(2, '0'),
        ].join('-');
        const inicio  = document.getElementById('fecha_inicio_ocupacion');
        const roceria = document.getElementById('fecha_roceria');
        if (inicio)            inicio.value  = iso;
        if (roceria && !roceria.value) roceria.value = iso;
        document.getElementById('loteForm').submit();
    });

});
</script>