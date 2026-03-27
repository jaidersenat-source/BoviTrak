<x-app-layout>
    <x-slot name="title">Vacunaciones – {{ $animal->nombre ?? $animal->codigo_nfc }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-bovi-dark flex items-center gap-2">
                <svg class="w-8 h-8 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
                Vacunaciones
            </h2>
            <span class="text-sm text-gray-500 font-medium">
                {{ $animal->nombre ?? $animal->codigo_nfc }}
            </span>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Alertas --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg shadow-md p-4 mb-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        {{-- Cabecera + botón nuevo --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-gray-500 text-sm">
                    Total: <span class="font-semibold text-gray-700">{{ $vaccinations->total() }}</span> registro(s)
                </p>
            </div>
            <a href="{{ route('animals.vaccinations.create', $animal) }}"
               class="btn-bovi-gradient px-5 py-2.5 rounded-lg shadow hover:shadow-lg flex items-center gap-2 text-sm font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Nueva Vacunación
            </a>
        </div>

        {{-- Tabla --}}
        @if($vaccinations->isEmpty())
            <div class="bg-white rounded-xl shadow border border-gray-100 p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <p class="text-gray-500 text-lg font-medium">Sin vacunaciones registradas</p>
                <p class="text-gray-400 text-sm mt-1">Registra la primera vacunación de este animal.</p>
                <a href="{{ route('animals.vaccinations.create', $animal) }}"
                   class="mt-5 inline-flex items-center gap-2 btn-bovi-gradient px-5 py-2.5 rounded-lg text-sm font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Agregar Vacunación
                </a>
            </div>
        @else
            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="card-header-green text-white text-left">
                                <th class="px-5 py-3 font-semibold">Vacuna</th>
                                <th class="px-5 py-3 font-semibold">Dosis</th>
                                <th class="px-5 py-3 font-semibold">Fecha</th>
                                <th class="px-5 py-3 font-semibold">Lote</th>
                                <th class="px-5 py-3 font-semibold">Aplicado por</th>
                                <th class="px-5 py-3 font-semibold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($vaccinations as $vac)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-5 py-4 font-semibold text-gray-800">
                                        {{ $vac->vacuna }}
                                    </td>
                                    <td class="px-5 py-4 text-gray-600">
                                        {{ $vac->dosis }}
                                    </td>
                                    <td class="px-5 py-4 text-gray-600 whitespace-nowrap">
                                        {{ $vac->fecha_vacunacion->format('d/m/Y') }}
                                    </td>
                                    <td class="px-5 py-4 text-gray-500">
                                        {{ $vac->lote ?? '—' }}
                                    </td>
                                    <td class="px-5 py-4 text-gray-500">
                                        {{ $vac->aplicador?->name ?? '—' }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Editar --}}
                                            <a href="{{ route('animals.vaccinations.edit', [$animal, $vac]) }}"
                                               class="inline-flex items-center gap-1 bg-amber-100 hover:bg-amber-200 text-amber-800 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Editar
                                            </a>
                                            {{-- Eliminar --}}
                                            <form method="POST"
                                                  action="{{ route('animals.vaccinations.destroy', [$animal, $vac]) }}"
                                                  onsubmit="return confirm('¿Eliminar esta vacunación?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                {{-- Nota expandida si existe --}}
                                @if($vac->nota)
                                    <tr class="bg-gray-50">
                                        <td colspan="6" class="px-5 py-2 text-xs text-gray-500 italic">
                                            📝 {{ $vac->nota }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Paginación --}}
            @if($vaccinations->hasPages())
                <div class="mt-4">
                    {{ $vaccinations->links() }}
                </div>
            @endif
        @endif

        {{-- Volver --}}
        <div class="mt-6">
            <a href="{{ route('admin.ganado.show', $animal) }}"
               class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al animal
            </a>
        </div>

    </div>
</x-app-layout>