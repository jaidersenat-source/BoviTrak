<x-app-layout>
    <x-slot name="title">Descendencia – {{ $animal->nombre ?? $animal->codigo_nfc }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-bovi-dark flex items-center gap-2">
                <svg class="w-8 h-8 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v6a4 4 0 004 4h8a4 4 0 004-4V7M12 3v4" />
                </svg>
                Descendencia
            </h2>
            <span class="text-sm text-gray-500 font-medium bg-gray-100 px-3 py-1 rounded-full">
                {{ $animal->nombre ?? $animal->codigo_nfc }}
            </span>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg shadow-md p-4 mb-6 flex items-center">
                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b bg-gray-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Detalles de la descendencia</h3>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('animals.descendencia.edit', [$animal, $descendencia]) }}" class="inline-flex items-center gap-2 bg-amber-100 hover:bg-amber-200 text-amber-800 text-xs font-semibold px-3 py-1.5 rounded-lg">
                            Editar
                        </a>
                        <form method="POST" action="{{ route('animals.descendencia.destroy', [$animal, $descendencia]) }}" onsubmit="return confirm('¿Eliminar este registro de descendencia?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-2 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-semibold px-3 py-1.5 rounded-lg">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Padre (Toro)</p>
                        @if($descendencia->padre)
                            <a href="{{ route('admin.ganado.show', $descendencia->padre) }}" class="font-semibold text-gray-800 hover:underline">{{ $descendencia->padre->nombre ?? $descendencia->padre->codigo_nfc }}</a>
                        @else
                            <p class="text-gray-400 italic">No registrado</p>
                        @endif
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Madre (Vaca)</p>
                        @if($descendencia->madre)
                            <a href="{{ route('admin.ganado.show', $descendencia->madre) }}" class="font-semibold text-gray-800 hover:underline">{{ $descendencia->madre->nombre ?? $descendencia->madre->codigo_nfc }}</a>
                        @else
                            <p class="text-gray-400 italic">No registrada</p>
                        @endif
                    </div>
                </div>

                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Fecha de nacimiento</p>
                    @if($descendencia->fecha_nacimiento)
                        <p class="font-semibold text-gray-800">{{ $descendencia->fecha_nacimiento->format('d/m/Y') }}</p>
                    @else
                        <p class="text-gray-400 italic">No registrada</p>
                    @endif
                </div>

                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Observaciones</p>
                    @if($descendencia->observaciones)
                        <p class="text-gray-700 whitespace-pre-line">{{ $descendencia->observaciones }}</p>
                    @else
                        <p class="text-gray-400 italic">—</p>
                    @endif
                </div>

                <div class="text-xs text-gray-400">
                    Registrado el {{ $descendencia->created_at->format('d/m/Y') }}
                    @if($descendencia->user) por <span class="font-medium text-gray-600">{{ $descendencia->user->name }}</span> @endif
                </div>
            </div>

            <div class="px-6 py-4 border-t bg-gray-50 flex items-center justify-between">
                <a href="{{ route('animals.descendencia.index', $animal) }}" class="text-sm text-gray-500 hover:underline">Volver al listado</a>
                <a href="{{ route('admin.ganado.show', $animal) }}" class="text-sm text-gray-500 hover:underline">Volver al animal</a>
            </div>
        </div>

    </div>
</x-app-layout>
