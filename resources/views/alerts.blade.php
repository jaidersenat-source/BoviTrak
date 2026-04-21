<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">Alertas del Sistema</h2>
	</x-slot>

	<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
		<div class="mb-4 flex items-center justify-between">
			<h3 class="text-lg font-medium">Todas las alertas (ganado & lotes)</h3>
			<div class="flex items-center gap-2">
				<a href="{{ route('admin.historial.export') }}" class="btn-bovi-gradient px-3 py-2 rounded text-white text-sm">Exportar PDF</a>
			</div>
		</div>

		<div class="bg-white shadow overflow-hidden sm:rounded-lg">
			<div class="px-4 py-3 border-b border-gray-100">Listado de alertas</div>
			<div class="p-4">
				@if(empty($alerts))
					<div class="text-center py-8 text-sm text-gray-500">No hay alertas en este momento.</div>
				@else
					<div class="overflow-x-auto">
						<table class="w-full text-sm">
							<thead class="text-left text-xs text-gray-500 uppercase">
								<tr>
									<th class="px-2 py-2">Tipo</th>
									<th class="px-2 py-2">Entidad</th>
									<th class="px-2 py-2">Nombre / Código</th>
									<th class="px-2 py-2">Mensaje</th>
									<th class="px-2 py-2">Detalle</th>
									<th class="px-2 py-2">Acción</th>
								</tr>
							</thead>
							<tbody>
								@foreach($alerts as $a)
								<tr class="border-t">
									<td class="px-2 py-2">{{ ucfirst($a['type'] ?? '—') }}</td>
									<td class="px-2 py-2">{{ ucfirst($a['entity'] ?? '—') }}</td>
									<td class="px-2 py-2 font-semibold">{{ $a['label'] ?? '—' }}</td>
									<td class="px-2 py-2">{{ $a['message'] ?? '—' }}</td>
									<td class="px-2 py-2 text-sm text-gray-600">{{ $a['detail'] ?? '—' }}</td>
									<td class="px-2 py-2">
										@if(($a['entity'] ?? '') === 'animal')
											<a href="{{ route('admin.ganado.show', $a['id']) }}" class="text-xs text-blue-600 hover:underline">Ver animal</a>
										@elseif(($a['entity'] ?? '') === 'lote')
											<a href="{{ route('admin.lotes.show', $a['id']) }}" class="text-xs text-blue-600 hover:underline">Ver lote</a>
										@else
											—
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endif
			</div>
		</div>
	</div>
</x-app-layout>
