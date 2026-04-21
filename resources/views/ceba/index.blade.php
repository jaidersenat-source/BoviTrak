<x-app-layout>
    <x-slot name="title">Ceba – {{ $animal->nombre ?? $animal->codigo_nfc }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-[var(--green-deep)] flex items-center gap-3">
                <svg class="w-8 h-8 text-[var(--green-mid)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v4a1 1 0 001 1h3m10-6v4a1 1 0 01-1 1h-3M7 21h10M12 3v18"/>
                </svg>
                Ceba
            </h2>
            <span class="text-sm text-gray-500 font-medium">{{ $animal->nombre ?? $animal->codigo_nfc }}</span>
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
                <p class="text-gray-500 text-sm">Total: <span class="font-semibold text-gray-700">{{ $cebas->count() }}</span> sesión(es)</p>
            </div>
            <a href="{{ route('animals.ceba.create', $animal) }}" class="btn-bovi-gradient px-5 py-2.5 rounded-lg shadow hover:shadow-lg flex items-center gap-2 text-sm font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Nueva sesión
            </a>
        </div>

        {{-- Contenido --}}
        @if($cebas->isEmpty())
            <div class="bg-white rounded-xl shadow border border-gray-100 p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v4a1 1 0 001 1h3m10-6v4a1 1 0 01-1 1h-3M7 21h10M12 3v18"/>
                </svg>
                <p class="text-gray-500 text-lg font-medium">Sin sesiones de ceba registradas</p>
                <p class="text-gray-400 text-sm mt-1">Registra la primera sesión de ceba para este animal.</p>
                <a href="{{ route('animals.ceba.create', $animal) }}" class="mt-5 inline-flex items-center gap-2 btn-bovi-gradient px-5 py-2.5 rounded-lg text-sm font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Agregar sesión
                </a>
            </div>
        @else
            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="card-header-green text-white text-left">
                                <th class="px-5 py-3 font-semibold">Ingreso</th>
                                <th class="px-5 py-3 font-semibold">Peso inicial</th>
                                <th class="px-5 py-3 font-semibold">Objetivo</th>
                                <th class="px-5 py-3 font-semibold">Registros</th>
                                <th class="px-5 py-3 font-semibold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($cebas as $c)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-5 py-4 font-semibold text-gray-800">{{ $c->fecha_ingreso ? \Carbon\Carbon::parse($c->fecha_ingreso)->format('d/m/Y') : '—' }}</td>
                                    <td class="px-5 py-4 text-gray-600">{{ $c->peso_inicial ?? '—' }} kg</td>
                                    <td class="px-5 py-4 text-gray-600">{{ $c->peso_objetivo ?? '—' }} kg</td>
                                    <td class="px-5 py-4 text-gray-600">{{ $c->registros()->count() }}</td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('animals.ceba.show', [$animal, $c]) }}" class="inline-flex items-center gap-1 bg-[var(--green-pale)] hover:bg-[var(--green-light)] text-[var(--green-deep)] text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Ver
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Volver --}}
        <div class="mt-6">
            <a href="{{ route('admin.ganado.index', $animal) }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Volver al animal
            </a>
        </div>

    </div>
</x-app-layout>
