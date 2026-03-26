<x-app-layout>
    <x-slot name="title">Proceso Reproductivo – {{ $animal->nombre ?? $animal->codigo_nfc }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-bovi-dark flex items-center gap-2">
                <svg class="w-8 h-8 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                Proceso Reproductivo
            </h2>
            <span class="text-sm text-gray-500 font-medium bg-gray-100 px-3 py-1 rounded-full">
                {{ $animal->nombre ?? $animal->codigo_nfc }}
            </span>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

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

        <div class="flex items-center justify-between mb-6">
            <p class="text-gray-500 text-sm">
                Total: <span class="font-semibold text-gray-700">{{ $records->total() }}</span> registro(s)
            </p>
            <a href="{{ route('animals.reproductive.create', $animal) }}"
               class="btn-bovi-gradient px-5 py-2.5 rounded-lg shadow hover:shadow-lg flex items-center gap-2 text-sm font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Nuevo Registro
            </a>
        </div>

        @if($records->isEmpty())
            <div class="bg-white rounded-xl shadow border border-gray-100 p-14 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <p class="text-gray-500 text-lg font-medium">Sin registros reproductivos</p>
                <p class="text-gray-400 text-sm mt-1">Registra el primer proceso reproductivo de este animal.</p>
                <a href="{{ route('animals.reproductive.create', $animal) }}"
                   class="mt-5 inline-flex items-center gap-2 btn-bovi-gradient px-5 py-2.5 rounded-lg text-sm font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Agregar Registro
                </a>
            </div>

        @else
            <div class="space-y-5">
                @foreach($records as $record)
                    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">

                        {{-- Header de tarjeta --}}
                        <div class="flex items-center justify-between px-5 py-3 bg-gray-50 border-b border-gray-100">
                            <div class="flex items-center gap-3 flex-wrap">
                                {{-- Badge tipo proceso --}}
                                @if($record->tipo_proceso)
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-full
                                        {{ $record->tipo_proceso === 'embrion'      ? 'bg-purple-100 text-purple-700' :
                                          ($record->tipo_proceso === 'inseminacion' ? 'bg-blue-100 text-blue-700' :
                                                                                      'bg-green-100 text-green-700') }}">
                                        @if($record->tipo_proceso === 'embrion') 🧬
                                        @elseif($record->tipo_proceso === 'inseminacion') 💉
                                        @else 🐄
                                        @endif
                                        {{ $record->tipo_proceso_label }}
                                    </span>
                                @endif

                                {{-- Badge palpación --}}
                                @if($record->palpacion)
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-green-100 text-green-700">
                                        ✅ Palpación realizada
                                    </span>
                                @endif

                                {{-- Días de gestación --}}
                                @if($record->dias_gestacion)
                                    <span class="text-xs text-gray-500">
                                        🗓 {{ $record->dias_gestacion }} días de gestación estimados
                                    </span>
                                @endif
                            </div>

                            {{-- Acciones --}}
                            <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ route('animals.reproductive.show', [$animal, $record]) }}"
                                   class="inline-flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Ver
                                </a>
                                <a href="{{ route('animals.reproductive.edit', [$animal, $record]) }}"
                                   class="inline-flex items-center gap-1 bg-amber-100 hover:bg-amber-200 text-amber-800 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Editar
                                </a>
                                <form method="POST"
                                      action="{{ route('animals.reproductive.destroy', [$animal, $record]) }}"
                                      onsubmit="return confirm('¿Eliminar este registro reproductivo?')">
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

                        {{-- Cuerpo: grid de 4 columnas resumen --}}
                        <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-gray-100 text-sm">

                            <div class="px-5 py-4">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Palpación</p>
                                @if($record->fecha_palpacion)
                                    <p class="font-semibold text-gray-800">{{ $record->fecha_palpacion->format('d/m/Y') }}</p>
                                @else
                                    <p class="text-gray-400 italic text-xs">No registrada</p>
                                @endif
                            </div>

                            <div class="px-5 py-4">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Dosis</p>
                                @if($record->dosis_reproductiva)
                                    <p class="font-semibold text-gray-800">{{ $record->dosis_reproductiva }}</p>
                                    @if($record->fecha_dosis)
                                        <p class="text-xs text-gray-500">{{ $record->fecha_dosis->format('d/m/Y') }}</p>
                                    @endif
                                @else
                                    <p class="text-gray-400 italic text-xs">No aplicada</p>
                                @endif
                            </div>

                            <div class="px-5 py-4">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Preñez</p>
                                @if($record->fecha_prenez)
                                    <p class="font-semibold text-gray-800">{{ $record->fecha_prenez->format('d/m/Y') }}</p>
                                @else
                                    <p class="text-gray-400 italic text-xs">No registrada</p>
                                @endif
                            </div>

                            <div class="px-5 py-4">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Parto estimado</p>
                                @if($record->fecha_estimada_parto)
                                    @php
                                        $diasRestantes = now()->diffInDays($record->fecha_estimada_parto, false);
                                    @endphp
                                    <p class="font-semibold text-gray-800">{{ $record->fecha_estimada_parto->format('d/m/Y') }}</p>
                                    <p class="text-xs mt-0.5
                                        {{ $diasRestantes > 30 ? 'text-green-600' : ($diasRestantes >= 0 ? 'text-amber-600' : 'text-red-500') }}">
                                        {{ $diasRestantes > 0 ? "Faltan {$diasRestantes} días" : ($diasRestantes === 0 ? '¡Hoy!' : 'Fecha pasada') }}
                                    </p>
                                @else
                                    <p class="text-gray-400 italic text-xs">No definida</p>
                                @endif
                            </div>

                        </div>

                        {{-- Observaciones --}}
                        @if($record->observaciones)
                            <div class="px-5 pb-4 border-t border-gray-100 pt-3">
                                <p class="text-xs text-gray-500 italic">📝 {{ $record->observaciones }}</p>
                            </div>
                        @endif

                        {{-- Registrado por --}}
                        <div class="px-5 pb-3 text-xs text-gray-400">
                            Registrado el {{ $record->created_at->format('d/m/Y') }}
                            @if($record->user) por <span class="font-medium text-gray-500">{{ $record->user->name }}</span> @endif
                        </div>

                    </div>
                @endforeach
            </div>

            @if($records->hasPages())
                <div class="mt-6">{{ $records->links() }}</div>
            @endif
        @endif

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