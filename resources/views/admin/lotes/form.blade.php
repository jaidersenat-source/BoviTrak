{{--
    Partial: resources/views/admin/lotes/form.blade.php
    Variables esperadas:
      - $lote : App\Models\Lotes (puede ser new App\Models\Lotes())
      - $action : URL del formulario
      - $method : 'POST' | 'PUT'
--}}

<form method="POST" action="{{ $action }}" id="loteForm" class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-white rounded-xl shadow border border-gray-100 p-6">
    @csrf
    @if(isset($method) && strtoupper($method) === 'PUT')
        @method('PUT')
    @endif

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold">{{ isset($lote) && $lote->exists ? 'Editar Lote' : 'Nuevo Lote' }}</h2>
        <a href="{{ route('admin.lotes.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Volver</a>
    </div>

    @if($errors->any())
        <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded">
            <ul class="text-sm text-red-700 list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label class="text-sm font-semibold text-gray-700">Código</label>
            <input type="text" name="codigo" required
                   value="{{ old('codigo', $lote->codigo ?? '') }}"
                   class="input-bovi w-full mt-1 @error('codigo') border-red-500 bg-red-50 @enderror">
            @error('codigo')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="text-sm font-semibold text-gray-700">Nombre de la pastura</label>
            <input type="text" name="nombre_pastura"
                   value="{{ old('nombre_pastura', $lote->nombre_pastura ?? '') }}"
                   class="input-bovi w-full mt-1">
        </div>

        <div class="sm:col-span-2">
            <label class="text-sm font-semibold text-gray-700">Banco nutricional</label>
            <textarea name="banco_nutricional" rows="3" class="input-bovi w-full mt-1">{{ old('banco_nutricional', $lote->banco_nutricional ?? '') }}</textarea>
        </div>

        <div>
            <label class="text-sm font-semibold text-gray-700">Tiempo ocupación (días)</label>
            <input type="number" name="tiempo_ocupacion_dias" min="0" step="1"
                   value="{{ old('tiempo_ocupacion_dias', $lote->tiempo_ocupacion_dias ?? '') }}"
                   class="input-bovi w-full mt-1">
        </div>

        <div>
            <label class="text-sm font-semibold text-gray-700">Tiempo descanso (días)</label>
            <input type="number" name="tiempo_descanso_dias" min="0" step="1"
                   value="{{ old('tiempo_descanso_dias', $lote->tiempo_descanso_dias ?? '') }}"
                   class="input-bovi w-full mt-1">
        </div>

        <div class="sm:col-span-2">
            <label class="text-sm font-semibold text-gray-700">Aplicación de abonos</label>
            <textarea name="aplicacion_abonos" rows="2" class="input-bovi w-full mt-1">{{ old('aplicacion_abonos', $lote->aplicacion_abonos ?? '') }}</textarea>
        </div>

        <div>
            <label class="text-sm font-semibold text-gray-700">Área (ha)</label>
            <input type="number" name="area_ha" min="0" step="0.01"
                   value="{{ old('area_ha', $lote->area_ha ?? '') }}"
                   class="input-bovi w-full mt-1">
        </div>

        <div class="sm:col-span-2">
            <label class="text-sm font-semibold text-gray-700">Observaciones</label>
            <textarea name="observaciones" rows="3" class="input-bovi w-full mt-1">{{ old('observaciones', $lote->observaciones ?? '') }}</textarea>
        </div>

        <div>
            <label class="text-sm font-semibold text-gray-700">Registrado por</label>
            <input type="text" value="{{ auth()->user()->name ?? '' }}" readonly class="input-bovi w-full mt-1 bg-gray-50">
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-4 mt-6">
        <button type="submit" id="submitLote" class="btn-bovi-gradient flex-1 py-3 px-5 rounded-lg shadow-lg hover:shadow-xl font-bold">
            {{ (isset($method) && strtoupper($method) === 'PUT') ? 'Actualizar lote' : 'Crear lote' }}
        </button>
        <a href="{{ route('admin.lotes.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-5 rounded-lg text-center">Cancelar</a>
    </div>

</form>

<script>
    document.getElementById('loteForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitLote');
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
    });

    // Validación mínima cliente
    document.querySelector('input[name="codigo"]').addEventListener('input', function (e) {
        if (!e.target.value.trim()) e.target.classList.add('border-red-500'); else e.target.classList.remove('border-red-500');
    });
</script>
