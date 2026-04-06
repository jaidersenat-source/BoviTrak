<x-app-layout>
    <x-slot name="title">Nuevo Registro Sanitario (Lote)</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 leading-tight tracking-tight">
                    Nuevo Registro Sanitario
                </h2>
                <p class="text-sm text-gray-500 mt-1">Aplicación por lote de animales</p>
            </div>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 bg-white border border-gray-200 hover:border-gray-300 px-3.5 py-2 rounded-lg transition-all duration-150">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-5">

        {{-- Errores --}}
        @if ($errors->any())
            <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3.5">
                <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-red-800 mb-1">Corrige los siguientes errores:</p>
                    <ul class="text-xs text-red-700 space-y-0.5 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('animals.health.batch.store', ['animal' => request()->route('animal')]) }}" id="sanitarioBatchForm">
            @csrf

            {{-- ── Selección de animales ── --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-800">Seleccionar animales</h3>
                    </div>
                    <span id="selectedCount" class="text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full hidden">
                        0 seleccionados
                    </span>
                </div>

                <div class="p-4">
                    {{-- Barra de búsqueda + Seleccionar todos --}}
                    <div class="flex gap-2 mb-3">
                        <div class="relative flex-1">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                            </svg>
                            <input
                                type="text"
                                id="animalSearch"
                                placeholder="Buscar por código o nombre…"
                                autocomplete="off"
                                class="w-full pl-9 pr-3 py-2 text-sm rounded-xl border border-gray-200 bg-gray-50 text-gray-800 placeholder-gray-400
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white transition-all"
                            >
                        </div>
                        <button type="button" id="toggleAll"
                            class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 border border-gray-200 px-3 py-2 rounded-xl transition-colors whitespace-nowrap">
                            Seleccionar todos
                        </button>
                    </div>

                    {{-- Lista de checkboxes --}}
                    <div id="animalList"
                         class="divide-y divide-gray-100 border border-gray-200 rounded-xl overflow-hidden max-h-64 overflow-y-auto">
                        @forelse($animals as $a)
                            <label id="row-{{ $a->id }}"
                                   class="animal-row flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-emerald-50 transition-colors duration-100 group"
                                   data-search="{{ strtolower($a->codigo_nfc . ' ' . ($a->nombre ?? '')) }}">
                                <input type="checkbox"
                                       name="animal_ids[]"
                                       value="{{ $a->id }}"
                                       class="animal-checkbox w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 focus:ring-offset-0 cursor-pointer"
                                       {{ in_array($a->id, old('animal_ids', [])) ? 'checked' : '' }}>
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <span class="shrink-0 inline-flex items-center justify-center w-7 h-7 rounded-lg bg-gray-100 group-hover:bg-emerald-100 text-xs font-semibold text-gray-500 group-hover:text-emerald-700 transition-colors">
                                        {{ strtoupper(substr($a->nombre ?? $a->codigo_nfc, 0, 2)) }}
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate">{{ $a->nombre ?? 'Sin nombre' }}</p>
                                        <p class="text-xs text-gray-400 font-mono truncate">{{ $a->codigo_nfc }}</p>
                                    </div>
                                </div>
                            </label>
                        @empty
                            <div class="px-4 py-8 text-center text-sm text-gray-400">
                                No hay animales registrados.
                            </div>
                        @endforelse
                    </div>

                    <div id="emptySearch" class="hidden text-center text-sm text-gray-400 py-6">
                        Sin resultados para tu búsqueda.
                    </div>
                </div>
            </div>
<br>
            {{-- ── Lavado ── --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="flex items-center gap-2.5 px-5 py-4 border-b border-gray-100">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800">Lavado</h3>
                </div>
                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label for="fecha_lavado" class="block text-xs font-medium text-gray-600 mb-1.5">
                            Fecha de lavado
                        </label>
                        <input type="date" name="fecha_lavado" id="fecha_lavado"
                               max="{{ date('Y-m-d') }}"
                               value="{{ old('fecha_lavado') }}"
                               class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all
                                      @error('fecha_lavado') border-red-400 bg-red-50 @enderror">
                        @error('fecha_lavado')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="producto_lavado" class="block text-xs font-medium text-gray-600 mb-1.5">
                            Producto utilizado <span class="text-gray-400 font-normal">(requerido con fecha)</span>
                        </label>
                        <input type="text" name="producto_lavado" id="producto_lavado"
                               value="{{ old('producto_lavado') }}"
                               placeholder="Ej: Cipermetrina"
                               class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all
                                      @error('producto_lavado') border-red-400 bg-red-50 @enderror">
                        @error('producto_lavado')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="producto_lavado_secundario" class="block text-xs font-medium text-gray-600 mb-1.5">
                            Segundo producto <span class="text-gray-400 font-normal">(opcional)</span>
                        </label>
                        <input type="text" name="producto_lavado_secundario" id="producto_lavado_secundario"
                               value="{{ old('producto_lavado_secundario') }}"
                               placeholder="Ej: Amitraz (mezcla)"
                               class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all">
                    </div>
                </div>
            </div>
<br>
            {{-- ── Purga ── --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="flex items-center gap-2.5 px-5 py-4 border-b border-gray-100">
                    <div class="w-7 h-7 rounded-lg bg-amber-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800">Purga <span class="text-xs font-normal text-gray-400 ml-1">(opcional)</span></h3>
                </div>
                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="fecha_purga" class="block text-xs font-medium text-gray-600 mb-1.5">Fecha de purga</label>
                        <input type="date" name="fecha_purga" id="fecha_purga"
                               max="{{ date('Y-m-d') }}"
                               value="{{ old('fecha_purga') }}"
                               class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900
                                      focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent focus:bg-white transition-all
                                      @error('fecha_purga') border-red-400 bg-red-50 @enderror">
                        @error('fecha_purga')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="tipo_purgante" class="block text-xs font-medium text-gray-600 mb-1.5">
                            Tipo de purgante <span class="text-gray-400 font-normal">(requerido con fecha)</span>
                        </label>
                        <input type="text" name="tipo_purgante" id="tipo_purgante"
                               value="{{ old('tipo_purgante') }}"
                               placeholder="Ej: Ivermectina"
                               class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400
                                      focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent focus:bg-white transition-all
                                      @error('tipo_purgante') border-red-400 bg-red-50 @enderror">
                        @error('tipo_purgante')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2">
                            Las purgas suelen registrarse individualmente por animal. Este campo aplica el mismo purgante a todos los seleccionados.
                        </p>
                    </div>
                </div>
            </div>
<br>
            {{-- ── Observaciones ── --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="flex items-center gap-2.5 px-5 py-4 border-b border-gray-100">
                    <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800">Observaciones <span class="text-xs font-normal text-gray-400 ml-1">(opcional)</span></h3>
                </div>
                <div class="p-5">
                    <textarea name="observaciones" id="observaciones" rows="3"
                              placeholder="Condición general del lote, incidencias, etc."
                              class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 resize-none
                                     focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white transition-all">{{ old('observaciones') }}</textarea>
                </div>
            </div>
<br>
            {{-- ── Acciones ── --}}
            <div class="flex items-center gap-3">
                <button type="submit" id="submitBtn"
                    class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors duration-150 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar registros
                </button>
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 bg-white border border-gray-200 hover:border-gray-300 px-5 py-2.5 rounded-xl transition-all">
                    Cancelar
                </a>
            </div>

        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {

        // ── Búsqueda de animales ──────────────────────────────────────────
        const searchInput  = document.getElementById('animalSearch');
        const rows         = document.querySelectorAll('.animal-row');
        const emptyMsg     = document.getElementById('emptySearch');
        const animalList   = document.getElementById('animalList');

        searchInput.addEventListener('input', () => {
            const q = searchInput.value.toLowerCase().trim();
            let visible = 0;
            rows.forEach(row => {
                const match = !q || row.dataset.search.includes(q);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            emptyMsg.classList.toggle('hidden', visible > 0);
            animalList.classList.toggle('hidden', visible === 0);
        });

        // ── Seleccionar / Deseleccionar todos ────────────────────────────
        const toggleBtn    = document.getElementById('toggleAll');
        const checkboxes   = document.querySelectorAll('.animal-checkbox');
        let allSelected    = false;

        toggleBtn.addEventListener('click', () => {
            allSelected = !allSelected;
            checkboxes.forEach(cb => {
                const row = cb.closest('.animal-row');
                if (row.style.display !== 'none') cb.checked = allSelected;
            });
            toggleBtn.textContent = allSelected ? 'Deseleccionar todos' : 'Seleccionar todos';
            updateCount();
        });

        // ── Contador de seleccionados ─────────────────────────────────────
        const countBadge = document.getElementById('selectedCount');

        function updateCount() {
            const n = document.querySelectorAll('.animal-checkbox:checked').length;
            if (n > 0) {
                countBadge.textContent = n + (n === 1 ? ' seleccionado' : ' seleccionados');
                countBadge.classList.remove('hidden');
            } else {
                countBadge.classList.add('hidden');
            }
        }

        checkboxes.forEach(cb => cb.addEventListener('change', updateCount));
        updateCount();

        // ── Highlight de fila seleccionada ───────────────────────────────
        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                const row = cb.closest('.animal-row');
                if (cb.checked) {
                    row.classList.add('bg-emerald-50');
                } else {
                    row.classList.remove('bg-emerald-50');
                }
            });
            if (cb.checked) cb.closest('.animal-row').classList.add('bg-emerald-50');
        });

        // ── Deshabilitar botón al enviar ──────────────────────────────────
        document.getElementById('sanitarioBatchForm').addEventListener('submit', function () {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
            btn.innerHTML = `
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                Guardando…`;
        });

    });
    </script>

</x-app-layout>