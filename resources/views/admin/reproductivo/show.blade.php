<x-app-layout>
    <x-slot name="title">Detalle Reproductivo – {{ $animal->nombre ?? $animal->codigo_nfc }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-bovi-dark flex items-center gap-2">
                <svg class="w-8 h-8 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Detalle Reproductivo
            </h2>
            <span class="text-sm text-gray-500 font-medium bg-gray-100 px-3 py-1 rounded-full">
                {{ $animal->nombre ?? $animal->codigo_nfc }}
            </span>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Acciones --}}
        <div class="flex justify-end gap-3 mb-6">
            <a href="{{ route('animals.reproductive.edit', [$animal, $reproductive]) }}"
               class="inline-flex items-center gap-2 bg-amber-100 hover:bg-amber-200 text-amber-800 text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar
            </a>
            <form method="POST" action="{{ route('animals.reproductive.destroy', [$animal, $reproductive]) }}"
                  onsubmit="return confirm('¿Eliminar este registro?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Eliminar
                </button>
            </form>
        </div>

        <div class="space-y-4">

            {{-- Sección 1: Palpación --}}
            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                <div class="px-5 py-3 bg-green-50 border-b border-green-100 flex items-center gap-2">
                    <span class="w-6 h-6 flex items-center justify-center rounded-full bg-green-200 text-green-800 text-xs font-bold">1</span>
                    <h3 class="font-bold text-green-800 text-sm uppercase tracking-wide">Palpación del Animal</h3>
                </div>
                <div class="p-5 grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Realizada</p>
                        <p class="font-semibold">{{ $reproductive->palpacion ? '✅ Sí' : '❌ No' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Fecha</p>
                        <p class="font-semibold">{{ $reproductive->fecha_palpacion?->format('d/m/Y') ?? '—' }}</p>
                    </div>
                    <div class="sm:col-span-3">
                        <p class="text-xs text-gray-400 mb-1">Observaciones</p>
                        <p class="text-gray-700">{{ $reproductive->observaciones_palpacion ?? '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- Sección 2: Dosis --}}
            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                <div class="px-5 py-3 bg-purple-50 border-b border-purple-100 flex items-center gap-2">
                    <span class="w-6 h-6 flex items-center justify-center rounded-full bg-purple-200 text-purple-800 text-xs font-bold">2</span>
                    <h3 class="font-bold text-purple-800 text-sm uppercase tracking-wide">Dosis Reproductiva</h3>
                </div>
                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Dosis aplicada</p>
                        <p class="font-semibold">{{ $reproductive->dosis_reproductiva ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Fecha de aplicación</p>
                        <p class="font-semibold">{{ $reproductive->fecha_dosis?->format('d/m/Y') ?? '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- Sección 3: Proceso y Preñez --}}
            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                <div class="px-5 py-3 bg-rose-50 border-b border-rose-100 flex items-center gap-2">
                    <span class="w-6 h-6 flex items-center justify-center rounded-full bg-rose-200 text-rose-800 text-xs font-bold">3</span>
                    <h3 class="font-bold text-rose-800 text-sm uppercase tracking-wide">Proceso Reproductivo y Preñez</h3>
                </div>
                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Tipo de proceso</p>
                        <p class="font-semibold">{{ $reproductive->tipo_proceso_label ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Fecha de preñez</p>
                        <p class="font-semibold">{{ $reproductive->fecha_prenez?->format('d/m/Y') ?? '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- Sección 4: Parto estimado --}}
            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                <div class="px-5 py-3 bg-amber-50 border-b border-amber-100 flex items-center gap-2">
                    <span class="w-6 h-6 flex items-center justify-center rounded-full bg-amber-200 text-amber-800 text-xs font-bold">4</span>
                    <h3 class="font-bold text-amber-800 text-sm uppercase tracking-wide">Fecha Estimada de Parto</h3>
                </div>
                <div class="p-5 text-sm">
                    @if($reproductive->fecha_estimada_parto)
                        @php $dias = now()->diffInDays($reproductive->fecha_estimada_parto, false); @endphp
                        <p class="font-bold text-2xl text-gray-800 mb-1">
                            {{ $reproductive->fecha_estimada_parto->format('d/m/Y') }}
                        </p>
                        <p class="text-sm {{ $dias > 30 ? 'text-green-600' : ($dias >= 0 ? 'text-amber-600 font-semibold' : 'text-red-500') }}">
                            {{ $dias > 0 ? "Faltan {$dias} días" : ($dias === 0 ? '🐄 ¡El parto es hoy!' : '⚠️ La fecha de parto ya pasó') }}
                        </p>
                        @if($reproductive->dias_gestacion)
                            <p class="text-xs text-gray-400 mt-1">Gestación estimada: {{ $reproductive->dias_gestacion }} días</p>
                        @endif
                    @else
                        <p class="text-gray-400 italic">No definida</p>
                    @endif
                </div>
            </div>

            {{-- Observaciones generales --}}
            @if($reproductive->observaciones)
                <div class="bg-white rounded-xl shadow border border-gray-100 p-5">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Observaciones Generales</p>
                    <p class="text-sm text-gray-700">{{ $reproductive->observaciones }}</p>
                </div>
            @endif

            {{-- Meta --}}
            <p class="text-xs text-gray-400 text-center">
                Registrado el {{ $reproductive->created_at->format('d/m/Y H:i') }}
                @if($reproductive->user) por {{ $reproductive->user->name }} @endif
            </p>

        </div>

        <div class="mt-6">
            <a href="{{ route('animals.reproductive.index', $animal) }}"
               class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al listado
            </a>
        </div>

    </div>
</x-app-layout>