<x-app-layout>
    <x-slot name="title">Registro Sanitario – {{ $animal->nombre ?? $animal->codigo_nfc }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-bovi-dark flex items-center gap-2">
                {{-- Ícono de escudo/salud --}}
                <svg class="w-8 h-8 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                
                Registro Sanitario
            </h2>
            <span class="text-sm text-gray-500 font-medium bg-gray-100 px-3 py-1 rounded-full">
                {{ $animal->nombre ?? $animal->codigo_nfc }}
            </span>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Alerta de éxito --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg shadow-md p-4 mb-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </button>
            </div>
        @endif

        {{-- Cabecera con conteo + botón nuevo --}}
        <div class="flex items-center justify-between mb-6">
            <p class="text-gray-500 text-sm">
                Total: <span class="font-semibold text-gray-700">{{ $records->total() }}</span> registro(s)
            </p>
            <a href="{{ route('animals.health.create', $animal) }}"
               class="btn-bovi-gradient px-5 py-2.5 rounded-lg shadow hover:shadow-lg flex items-center gap-2 text-sm font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                Nuevo Registro
            </a>
        </div>
        

        {{-- Sin registros --}}
        @if($records->isEmpty())
            <div class="bg-white rounded-xl shadow border border-gray-100 p-14 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <p class="text-gray-500 text-lg font-medium">Sin registros sanitarios</p>
                <p class="text-gray-400 text-sm mt-1">Registra el primer control sanitario de este animal.</p>
                <a href="{{ route('animals.health.create', $animal) }}"
                   class="mt-5 inline-flex items-center gap-2 btn-bovi-gradient px-5 py-2.5 rounded-lg text-sm font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Agregar Registro
                </a>
            </div>

        {{-- Tabla de registros --}}
        @else
            <div class="space-y-4">
                @foreach($records as $record)
                    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200">

                        {{-- Encabezado de la tarjeta --}}
                        <div class="flex items-center justify-between px-5 py-3 bg-gray-50 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                {{-- Badge de tipo --}}
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full
                                    {{ $record->fecha_lavado && $record->fecha_purga
                                        ? 'bg-purple-100 text-purple-700'
                                        : ($record->fecha_lavado
                                            ? 'bg-blue-100 text-blue-700'
                                            : 'bg-amber-100 text-amber-700') }}">
                                    {{ $record->tipo }}
                                </span>
                                <span class="text-xs text-gray-400">
                                    Registrado el {{ $record->created_at->format('d/m/Y') }}
                                    @if($record->user)
                                        por <span class="font-medium text-gray-600">{{ $record->user->name }}</span>
                                    @endif
                                </span>
                            </div>
                            {{-- Acciones --}}
                            <div class="flex items-center gap-2">
                                <a href="{{ route('animals.health.edit', [$animal, $record]) }}"
                                   class="inline-flex items-center gap-1 bg-amber-100 hover:bg-amber-200 text-amber-800 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Editar
                                </a>
                                <form method="POST"
                                      action="{{ route('animals.health.destroy', [$animal, $record]) }}"
                                      onsubmit="return confirm('¿Eliminar este registro sanitario?')">
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
                        </div>

                        {{-- Cuerpo: dos secciones en columnas --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-gray-100">

                            {{-- Sección 1: Lavado --}}
                            <div class="p-5">
                                <h4 class="text-xs font-bold uppercase tracking-wide text-blue-600 mb-3 flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                    Lavado Antiparasitario
                                </h4>
                                @if($record->fecha_lavado)
                                    <dl class="space-y-1 text-sm">
                                        <div class="flex gap-2">
                                            <dt class="text-gray-500 w-20 shrink-0">Fecha:</dt>
                                            <dd class="font-semibold text-gray-800">{{ $record->fecha_lavado->format('d/m/Y') }}</dd>
                                        </div>
                                        <div class="flex gap-2">
                                            <dt class="text-gray-500 w-20 shrink-0">Producto:</dt>
                                            <dd class="font-semibold text-gray-800">{{ $record->producto_lavado ?? '—' }}</dd>
                                        </div>
                                        @if($record->producto_lavado_secundario)
                                            <div class="flex gap-2">
                                                <dt class="text-gray-500 w-20 shrink-0">Otro:</dt>
                                                <dd class="font-semibold text-gray-800">{{ $record->producto_lavado_secundario }}</dd>
                                            </div>
                                        @endif
                                    </dl>
                                @else
                                    <p class="text-sm text-gray-400 italic">No registrado</p>
                                @endif
                            </div>

                            {{-- Sección 2: Purga --}}
                            <div class="p-5">
                                <h4 class="text-xs font-bold uppercase tracking-wide text-amber-600 mb-3 flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    Purga
                                </h4>
                                @if($record->fecha_purga)
                                    <dl class="space-y-1 text-sm">
                                        <div class="flex gap-2">
                                            <dt class="text-gray-500 w-20 shrink-0">Fecha:</dt>
                                            <dd class="font-semibold text-gray-800">{{ $record->fecha_purga->format('d/m/Y') }}</dd>
                                        </div>
                                        <div class="flex gap-2">
                                            <dt class="text-gray-500 w-20 shrink-0">Purgante:</dt>
                                            <dd class="font-semibold text-gray-800">{{ $record->tipo_purgante ?? '—' }}</dd>
                                        </div>
                                    </dl>
                                @else
                                    <p class="text-sm text-gray-400 italic">No registrado</p>
                                @endif
                            </div>
                        </div>

                        {{-- Observaciones --}}
                        @if($record->observaciones)
                            <div class="px-5 pb-4 border-t border-gray-100 pt-3">
                                <p class="text-xs text-gray-500 italic">
                                    📝 {{ $record->observaciones }}
                                </p>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            @if($records->hasPages())
                <div class="mt-6">
                    {{ $records->links() }}
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