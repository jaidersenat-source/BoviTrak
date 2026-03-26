{{--
    Partial reutilizable: resources/views/admin/vacunaciones/_form.blade.php
    Variables esperadas:
      - $animal  : Animal
      - $vaccination : AnimalVaccination (puede ser new AnimalVaccination())
      - $action  : URL del formulario
      - $method  : 'POST' | 'PUT'
--}}

<form method="POST" action="{{ $action }}" id="vacunacionForm">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    {{-- ── Vacuna ─────────────────────────────────────────── --}}
    <div class="mb-5">
        <label for="vacuna" class="block text-sm font-semibold text-gray-700 mb-2">
            Vacuna <span class="text-red-600">*</span>
        </label>
        <input
            type="text"
            name="vacuna"
            id="vacuna"
            value="{{ old('vacuna', $vaccination->vacuna ?? '') }}"
            placeholder="Ej: Fiebre Aftosa, Brucelosis, IBR..."
            class="input-bovi w-full @error('vacuna') border-red-500 bg-red-50 @enderror"
            required
        >
        @error('vacuna')
            <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- ── Dosis ──────────────────────────────────────────── --}}
    <div class="mb-5">
        <label for="dosis" class="block text-sm font-semibold text-gray-700 mb-2">
            Dosis Aplicada <span class="text-red-600">*</span>
        </label>
        <input
            type="text"
            name="dosis"
            id="dosis"
            value="{{ old('dosis', $vaccination->dosis ?? '') }}"
            placeholder="Ej: 2 ml, 1 dosis, 5 cc..."
            class="input-bovi w-full @error('dosis') border-red-500 bg-red-50 @enderror"
            required
        >
        @error('dosis')
            <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- ── Fecha de vacunación ─────────────────────────────── --}}
    <div class="mb-5">
        <label for="fecha_vacunacion" class="block text-sm font-semibold text-gray-700 mb-2">
            Fecha de Vacunación <span class="text-red-600">*</span>
        </label>
        <input
            type="date"
            name="fecha_vacunacion"
            id="fecha_vacunacion"
            value="{{ old('fecha_vacunacion', isset($vaccination->fecha_vacunacion) ? $vaccination->fecha_vacunacion->format('Y-m-d') : date('Y-m-d')) }}"
            max="{{ date('Y-m-d') }}"
            class="input-bovi w-full @error('fecha_vacunacion') border-red-500 bg-red-50 @enderror"
            required
        >
        @error('fecha_vacunacion')
            <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $message }}
            </p>
        @enderror
        <p class="mt-1 text-xs text-gray-500">No puede ser una fecha futura.</p>
    </div>

    {{-- ── Lote ────────────────────────────────────────────── --}}
    <div class="mb-5">
        <label for="lote" class="block text-sm font-semibold text-gray-700 mb-2">
            Lote del Producto
        </label>
        <input
            type="text"
            name="lote"
            id="lote"
            value="{{ old('lote', $vaccination->lote ?? '') }}"
            placeholder="Ej: LOT-2024-001"
            class="input-bovi w-full @error('lote') border-red-500 bg-red-50 @enderror"
        >
        @error('lote')
            <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $message }}
            </p>
        @enderror
        <p class="mt-1 text-xs text-gray-500">Opcional. Número de lote del biológico.</p>
    </div>

    {{-- ── Nota ────────────────────────────────────────────── --}}
    <div class="mb-6">
        <label for="nota" class="block text-sm font-semibold text-gray-700 mb-2">
            Nota
        </label>
        <textarea
            name="nota"
            id="nota"
            rows="3"
            placeholder="Observaciones adicionales sobre la vacunación..."
            class="input-bovi w-full @error('nota') border-red-500 bg-red-50 @enderror"
        >{{ old('nota', $vaccination->nota ?? '') }}</textarea>
        @error('nota')
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
            {{ $method === 'PUT' ? 'Actualizar Vacunación' : 'Guardar Vacunación' }}
        </button>
        <a href="{{ route('animals.vaccinations.index', $animal) }}"
           class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 px-6 rounded-lg transition-all flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Cancelar
        </a>
    </div>

</form>

<script>
    document.getElementById('vacunacionForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
    });
</script>