<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Historial Administrativo - Ganado</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-medium">Resumen de todo el ganado</h3>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.historial.export') }}" class="btn-bovi-gradient px-3 py-2 rounded text-white text-sm">Descargar PDF</a>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-3 border-b border-gray-100">Listado de animales</div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-left text-xs text-gray-500 uppercase">
                            <tr>
                                <th class="px-2 py-2">ID</th>
                                <th class="px-2 py-2">Código</th>
                                <th class="px-2 py-2">Nombre</th>
                                <th class="px-2 py-2">Raza</th>
                                <th class="px-2 py-2">Sexo</th>
                                <th class="px-2 py-2">Último peso</th>
                                <th class="px-2 py-2">Últ. peso fecha</th>
                                <th class="px-2 py-2">Vacunas</th>
                                <th class="px-2 py-2">Sanitario</th>
                                <th class="px-2 py-2">Ceba</th>
                                <th class="px-2 py-2">Descendencia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($animals as $animal)
                                <tr class="border-t">
                                    <td class="px-2 py-2">{{ $animal->id }}</td>
                                    <td class="px-2 py-2">{{ $animal->codigo_nfc ?? '-' }}</td>
                                    <td class="px-2 py-2">{{ $animal->nombre ?? '-' }}</td>
                                    <td class="px-2 py-2">{{ $animal->raza ?? '-' }}</td>
                                    <td class="px-2 py-2">{{ ucfirst($animal->sexo ?? '-') }}</td>
                                    <td class="px-2 py-2">{{ $animal->latestWeight ? $animal->latestWeight->weight.' kg' : '-' }}</td>
                                    <td class="px-2 py-2">{{ $animal->latestWeight ? $animal->latestWeight->measured_at->format('Y-m-d') : '-' }}</td>
                                    <td class="px-2 py-2">{{ $animal->vaccinations->count() }}</td>
                                    <td class="px-2 py-2">{{ $animal->healthRecords->count() }}</td>
                                    <td class="px-2 py-2">{{ $animal->cebas->count() }}</td>
                                    <td class="px-2 py-2">{{ $animal->asPadre->count() + $animal->asMadre->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
