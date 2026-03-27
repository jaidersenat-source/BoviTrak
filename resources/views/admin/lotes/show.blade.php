<x-app-layout>
    <x-slot name="title">Lote – {{ $lote->codigo }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-bovi-dark flex items-center gap-2">
                <svg class="w-8 h-8 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7"/>
                </svg>
                Lote {{ $lote->codigo }}
            </h2>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.lotes.edit', $lote) }}" class="btn-bovi-outline px-4 py-2 rounded">Editar</a>
                <a href="{{ route('admin.lotes.index') }}" class="ml-2 text-sm text-gray-500 hover:text-gray-700">Volver</a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b">
                <h3 class="text-lg font-semibold">Información del lote</h3>
            </div>
            <div class="p-6 space-y-4 text-sm text-gray-700">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-xs text-gray-500">Código</span>
                        <p class="font-medium">{{ $lote->codigo }}</p>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500">Nombre pastura</span>
                        <p>{{ $lote->nombre_pastura ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500">Área (ha)</span>
                        <p>{{ $lote->area_ha ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500">Ocupación / Descanso (días)</span>
                        <p>{{ $lote->tiempo_ocupacion_dias ?? '-' }} / {{ $lote->tiempo_descanso_dias ?? '-' }}</p>
                    </div>
                </div>

                <div>
                    <span class="block text-xs text-gray-500">Banco nutricional</span>
                    <p class="whitespace-pre-line">{{ $lote->banco_nutricional ?? '-' }}</p>
                </div>

                <div>
                    <span class="block text-xs text-gray-500">Aplicación de abonos</span>
                    <p class="whitespace-pre-line">{{ $lote->aplicacion_abonos ?? '-' }}</p>
                </div>

                <div>
                    <span class="block text-xs text-gray-500">Observaciones</span>
                    <p class="whitespace-pre-line">{{ $lote->observaciones ?? '-' }}</p>
                </div>

                <div class="flex items-center justify-between pt-4 border-t text-xs text-gray-500">
                    <div>
                        Registrado por: <span class="font-medium text-gray-700">{{ $lote->user->name ?? '—' }}</span>
                    </div>
                    <div>
                        Creado: {{ $lote->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
