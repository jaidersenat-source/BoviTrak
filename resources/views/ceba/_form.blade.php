{{-- Partial reutilizable de formulario de Ceba
     Variables esperadas:
       - $animal : App\Models\Animal
       - $ceba   : App\Models\Ceba|null
       - $action : URL
       - $method : 'POST'|'PUT'
--}}

<form method="POST" action="{{ $action }}" id="cebaForm">
    @csrf
    @if(isset($method) && strtoupper($method) === 'PUT')
        @method('PUT')
    @endif

    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="p-4 sm:p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
                <div>
                    <label class="label-bovi">Fecha de ingreso</label>
                    <input type="date" name="fecha_ingreso" class="input-bovi w-full" value="{{ old('fecha_ingreso', optional($ceba)->fecha_ingreso ? \Carbon\Carbon::parse($ceba->fecha_ingreso)->format('Y-m-d') : '') }}">
                    @error('fecha_ingreso') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="label-bovi">Destino / Lote</label>
                    <input type="text" name="destino_lote" class="input-bovi w-full" value="{{ old('destino_lote', $ceba->destino_lote ?? '') }}">
                    @error('destino_lote') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="label-bovi">Peso inicial (kg)</label>
                    <input type="number" step="0.1" name="peso_inicial" class="input-bovi w-full" value="{{ old('peso_inicial', $ceba->peso_inicial ?? '') }}">
                    @error('peso_inicial') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="label-bovi">Peso objetivo (kg)</label>
                    <input type="number" step="0.1" name="peso_objetivo" class="input-bovi w-full" value="{{ old('peso_objetivo', $ceba->peso_objetivo ?? '') }}">
                    @error('peso_objetivo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="label-bovi">Observaciones</label>
                <textarea name="observaciones" class="textarea-bovi w-full min-h-[120px]">{{ old('observaciones', $ceba->observaciones ?? '') }}</textarea>
                @error('observaciones') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3">
                <a href="{{ route('animals.ceba.index', $animal) }}" class="w-full sm:w-auto text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-lg">Cancelar</a>
                <button type="submit" id="submitCeba" class="w-full sm:w-auto btn-bovi-gradient px-5 py-2.5 rounded-lg shadow hover:shadow-lg flex items-center justify-center gap-2 text-sm font-bold">{{ strtoupper($method ?? 'POST') === 'PUT' ? 'Actualizar sesión' : 'Crear sesión' }}</button>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById('cebaForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitCeba');
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
        try { btn.dataset.orig = btn.innerHTML; btn.innerHTML = 'Guardando...'; } catch(e){}
    });
</script>
