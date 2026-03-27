@php
	$action = route('animals.milk.store', $animal);
	$method = 'POST';
	$record = new \App\Models\MilkProduction();
@endphp

<x-app-layout>
	<x-slot name="title">Nuevo Registro de Producción – {{ $animal->nombre ?? $animal->codigo_nfc }}</x-slot>
	<x-slot name="header">
		<div class="flex items-center justify-between">
			<h2 class="text-3xl font-bold text-bovi-dark flex items-center gap-2">
				<svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2s5 5.5 5 9a5 5 0 11-10 0c0-3.5 5-9 5-9z" />
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 7v5" />
				</svg>
				Nuevo Registro de Producción
			</h2>
			<span class="text-sm text-gray-500 font-medium bg-gray-100 px-3 py-1 rounded-full">
				{{ $animal->nombre ?? $animal->codigo_nfc }}
			</span>
		</div>
	</x-slot>

	<div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

		@if ($errors->any())
			<div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow-md p-4 mb-6">
				<div class="flex items-start gap-3">
					<svg class="w-6 h-6 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
					</svg>
					<div>
						<h3 class="font-bold text-red-800 mb-1">Corrige los siguientes errores:</h3>
						<ul class="list-disc list-inside text-sm text-red-700 space-y-1">
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		@endif

		<div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
			<div class="card-header-sky">
				<h3 class="text-xl font-bold text-white flex items-center gap-2">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2s5 5.5 5 9a5 5 0 11-10 0c0-3.5 5-9 5-9z" />
					</svg>
					Registro de Producción de Leche
				</h3>
			</div>
			<div class="p-6">
				@include('admin.milk.form', [
					'animal' => $animal,
					'record' => $record,
					'action' => $action,
					'method' => $method,
				])
			</div>
		</div>

	</div>
</x-app-layout>
