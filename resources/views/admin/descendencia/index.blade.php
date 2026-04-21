<x-app-layout>
    <x-slot name="title">Registro de Descendencia – {{ $animal->nombre ?? $animal->codigo_nfc }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-bovi-dark flex items-center gap-2">
                <svg class="w-8 h-8 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v6a4 4 0 004 4h8a4 4 0 004-4V7M12 3v4" />
                </svg>
                Registro de Descendencia
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
            <a href="{{ route('animals.descendencia.create', $animal) }}"
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <p class="text-gray-500 text-lg font-medium">Sin registros de descendencia</p>
                <p class="text-gray-400 text-sm mt-1">Registra los padres (toro y vaca) de este animal.</p>
                <a href="{{ route('animals.descendencia.create', $animal) }}"
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
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-medium text-gray-700">Registro #{{ $record->id }}</span>
                            </div>

                            {{-- Acciones --}}
                            <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ route('animals.descendencia.show', [$animal, $record]) }}"
                                   class="inline-flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                    Ver
                                </a>
                                <a href="{{ route('animals.descendencia.edit', [$animal, $record]) }}"
                                   class="inline-flex items-center gap-1 bg-amber-100 hover:bg-amber-200 text-amber-800 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                    Editar
                                </a>
                                <form method="POST"
                                      action="{{ route('animals.descendencia.destroy', [$animal, $record]) }}"
                                      onsubmit="return confirm('¿Eliminar este registro de descendencia?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Cuerpo: padre / madre / fecha / observaciones --}}
                        <div class="grid grid-cols-1 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-gray-100 text-sm">

                            <div class="px-5 py-4">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Padre (Toro)</p>
                                @if($record->padre)
                                    <a href="{{ route('admin.ganado.show', $record->padre) }}" class="font-semibold text-gray-800 hover:underline">{{ $record->padre->nombre ?? $record->padre->codigo_nfc }}</a>
                                    @if(!empty($record->padre->raza))
                                        <p class="text-xs text-gray-500">Raza: {{ $record->padre->raza }}</p>
                                    @endif
                                @else
                                    @if(!empty($record->padre_nombre) || !empty($record->padre_raza))
                                        <p class="font-semibold text-gray-800">{{ $record->padre_nombre ?? '—' }}</p>
                                        @if(!empty($record->padre_raza))
                                            <p class="text-xs text-gray-500">Raza: {{ $record->padre_raza }}</p>
                                        @endif
                                    @else
                                        <p class="text-gray-400 italic text-xs">No registrado</p>
                                    @endif
                                @endif
                            </div>

                            <div class="px-5 py-4">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Madre (Vaca)</p>
                                @if($record->madre)
                                    <a href="{{ route('admin.ganado.show', $record->madre) }}" class="font-semibold text-gray-800 hover:underline">{{ $record->madre->nombre ?? $record->madre->codigo_nfc }}</a>
                                    @if(!empty($record->madre->raza))
                                        <p class="text-xs text-gray-500">Raza: {{ $record->madre->raza }}</p>
                                    @endif
                                @else
                                    @if(!empty($record->madre_nombre) || !empty($record->madre_raza))
                                        <p class="font-semibold text-gray-800">{{ $record->madre_nombre ?? '—' }}</p>
                                        @if(!empty($record->madre_raza))
                                            <p class="text-xs text-gray-500">Raza: {{ $record->madre_raza }}</p>
                                        @endif
                                    @else
                                        <p class="text-gray-400 italic text-xs">No registrado</p>
                                    @endif
                                @endif
                            </div>

                            <div class="px-5 py-4">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Fecha de Nacimiento</p>
                                @if($record->fecha_nacimiento)
                                    <p class="font-semibold text-gray-800">{{ $record->fecha_nacimiento->format('d/m/Y') }}</p>
                                @else
                                    <p class="text-gray-400 italic text-xs">No registrada</p>
                                @endif
                            </div>

                            <div class="px-5 py-4">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Observaciones</p>
                                @if($record->observaciones)
                                    <p class="text-gray-700">{{ Str::limit($record->observaciones, 200) }}</p>
                                @else
                                    <p class="text-gray-400 italic text-xs">—</p>
                                @endif
                            </div>

                        </div>

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
