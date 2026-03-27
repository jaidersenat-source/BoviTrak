{{--
	Partial: resources/views/admin/milk/form.blade.php
	Variables esperadas:
	  - $animal : Animal
	  - $record : MilkProduction (puede ser null o new App\Models\MilkProduction())
	  - $action : URL del formulario
	  - $method : 'POST' | 'PUT'
--}}

<form method="POST" action="{{ $action }}" id="milkForm" class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-white rounded-xl shadow border border-gray-100 p-6">
	@csrf
	@if(isset($method) && strtoupper($method) === 'PUT')
		@method('PUT')
	@endif

	<div class="mb-6 flex items-center justify-between">
		<h2 class="text-2xl font-bold">{{ isset($record) ? 'Editar registro de leche' : 'Nuevo registro de producción' }}</h2>
		<a href="{{ route('animals.milk.index', $animal) }}" class="text-sm text-gray-500 hover:text-gray-700">Volver</a>
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

	{{-- SECCIÓN 1: Datos básicos de extracción --}}
	<div class="mb-6">
		<div class="flex items-center gap-2 mb-4">
			<div class="flex items-center justify-center w-7 h-7 rounded-full bg-sky-100 text-sky-700 text-xs font-bold shrink-0">1</div>
			<h4 class="text-base font-bold text-sky-700">Datos de extracción</h4>
		</div>

		<div class="bg-sky-50 rounded-xl p-5 space-y-4 border border-sky-100">
			<div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
				<div>
					<label class="text-sm font-semibold text-gray-700">Fecha</label>
					<input type="date" name="date" required
						   value="{{ old('date', isset($record) && $record->date ? $record->date->format('Y-m-d') : now()->format('Y-m-d')) }}"
						   class="input-bovi w-full mt-1 @error('date') border-red-500 bg-red-50 @enderror">
					@error('date')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
				</div>

				<div>
					<label class="text-sm font-semibold text-gray-700">Litros</label>
					<input type="number" name="liters" step="0.01" min="0" required
						   value="{{ old('liters', $record->liters ?? '') }}"
						   class="input-bovi w-full mt-1 @error('liters') border-red-500 bg-red-50 @enderror">
					@error('liters')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
				</div>

				<div>
					<label class="text-sm font-semibold text-gray-700">Turno</label>
					<select name="shift" class="input-bovi w-full mt-1">
						@php $oldShift = old('shift', $record->shift ?? '') @endphp
						<option value="">-- Seleccionar --</option>
						<option value="manana" {{ $oldShift === 'manana' ? 'selected' : '' }}>Mañana</option>
						<option value="tarde" {{ $oldShift === 'tarde' ? 'selected' : '' }}>Tarde</option>
						<option value="noche" {{ $oldShift === 'noche' ? 'selected' : '' }}>Noche</option>
					</select>
				</div>
			</div>
		</div>
	</div>

	{{-- SECCIÓN 2: Calidad y observaciones --}}
	<div class="mb-6">
		<div class="flex items-center gap-2 mb-4">
			<div class="flex items-center justify-center w-7 h-7 rounded-full bg-amber-100 text-amber-700 text-xs font-bold shrink-0">2</div>
			<h4 class="text-base font-bold text-amber-700">Calidad y observaciones</h4>
		</div>

		<div class="bg-amber-50 rounded-xl p-5 space-y-4 border border-amber-100">
			<div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
				<div>
					<label class="text-sm font-semibold text-gray-700">Células somáticas (SCC)</label>
					<input type="number" name="somatic_cells" step="1" min="0"
						   value="{{ old('somatic_cells', $record->somatic_cells ?? '') }}"
						   class="input-bovi w-full mt-1">
					<p class="text-xs text-gray-500 mt-1">Valor aproximado (opcional)</p>
				</div>

				<div>
					<label class="text-sm font-semibold text-gray-700">Mastitis sospechada</label>
					<div class="mt-1">
						<label class="inline-flex items-center gap-2">
							<input type="checkbox" name="mastitis" value="1" class="form-checkbox" {{ old('mastitis', $record->mastitis ?? false) ? 'checked' : '' }}>
							<span class="text-sm text-gray-700">Sí</span>
						</label>
					</div>
				</div>

				<div>
					<label class="text-sm font-semibold text-gray-700">Registrado por</label>
					<input type="text" value="{{ auth()->user()->name ?? '' }}" readonly class="input-bovi w-full mt-1 bg-gray-50">
				</div>
			</div>

			<div>
				<label class="text-sm font-semibold text-gray-700">Notas</label>
				<textarea name="notes" rows="3" class="input-bovi w-full mt-1">{{ old('notes', $record->notes ?? '') }}</textarea>
				<p class="text-xs text-gray-500 mt-1">Opcional. Describe condiciones, calidad, observaciones del ordeño.</p>
			</div>
		</div>
	</div>

	{{-- BOTONES --}}
	<div class="flex flex-col sm:flex-row gap-4">
		<button type="submit" id="submitBtn" class="btn-bovi-gradient flex-1 py-3 px-5 rounded-lg shadow-lg hover:shadow-xl font-bold">
			{{ (isset($method) && strtoupper($method) === 'PUT') ? 'Actualizar registro' : 'Guardar registro' }}
		</button>
		<a href="{{ route('animals.milk.index', $animal) }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-5 rounded-lg text-center">Cancelar</a>
	</div>

</form>

<script>
	// Desactivar botón al enviar
	document.getElementById('milkForm').addEventListener('submit', function () {
		const btn = document.getElementById('submitBtn');
		btn.disabled = true;
		btn.classList.add('opacity-75', 'cursor-not-allowed');
	});

	// Validación mínima cliente: litros >= 0
	document.querySelector('input[name="liters"]').addEventListener('input', function (e) {
		const v = parseFloat(e.target.value);
		if (isNaN(v) || v < 0) {
			e.target.classList.add('border-red-500');
		} else {
			e.target.classList.remove('border-red-500');
		}
	});
</script>
