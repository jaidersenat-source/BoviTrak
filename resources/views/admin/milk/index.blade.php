<x-app-layout>
    <x-slot name="title">Producción de Leche – {{ $animal->nombre ?? $animal->codigo_nfc }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-bovi-dark flex items-center gap-2">
                <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2s5 5.5 5 9a5 5 0 11-10 0c0-3.5 5-9 5-9z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 7v5" />
                </svg>
                Producción de Leche
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
            <a href="{{ route('animals.milk.create', $animal) }}"
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2s5 5.5 5 9a5 5 0 11-10 0c0-3.5 5-9 5-9z" />
                </svg>
                <p class="text-gray-500 text-lg font-medium">Sin registros de producción</p>
                <p class="text-gray-400 text-sm mt-1">Registra el primer control de producción de esta vaca.</p>
                <a href="{{ route('animals.milk.create', $animal) }}"
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

                        <div class="flex items-center justify-between px-5 py-3 bg-gray-50 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-sky-100 text-sky-700">{{ $record->date->format('d/m/Y') }}</span>
                                <div class="text-sm">
                                    <p class="font-bold text-gray-800">{{ $record->liters }} L</p>
                                    <div class="flex items-center gap-3 text-xs text-gray-500 mt-1">
                                        @if($record->shift)
                                            <span class="px-2 py-0.5 rounded bg-gray-100">Turno: <span class="font-semibold text-gray-700">{{ ucfirst($record->shift) }}</span></span>
                                        @endif
                                        @if($record->somatic_cells)
                                            <span class="px-2 py-0.5 rounded bg-gray-100">SCC: <span class="font-semibold text-gray-700">{{ number_format($record->somatic_cells) }}</span></span>
                                        @endif
                                        <span class="px-2 py-0.5 rounded {{ $record->mastitis ? 'bg-red-100 text-red-700' : 'bg-green-50 text-green-700' }}">
                                            {{ $record->mastitis ? 'Mastitis sospechada' : 'Sin mastitis' }}
                                        </span>
                                    </div>
                                    @if($record->notes)
                                        <p class="text-xs text-gray-500 mt-2">{{ Str::limit($record->notes, 120) }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                               
                                <a href="{{ route('animals.milk.edit', [$animal, $record]) }}"
                                   class="inline-flex items-center gap-1 bg-amber-100 hover:bg-amber-200 text-amber-800 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                    Editar
                                </a>
                                <form method="POST" action="{{ route('animals.milk.destroy', [$animal, $record]) }}" onsubmit="return confirm('¿Eliminar este registro de producción?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="px-5 py-4 text-sm text-gray-500 flex items-center justify-between">
                            <div>
                                Registrado el {{ $record->created_at->format('d/m/Y H:i') }}
                                @if($record->user)
                                    · por <span class="font-medium text-gray-700">{{ $record->user->name }}</span>
                                @endif
                            </div>
                            <div class="text-xs text-gray-400">
                                ID: #{{ str_pad($record->id, 4, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            @if($records->hasPages())
                <div class="mt-6">{{ $records->links() }}</div>
            @endif
        @endif

        <div class="mt-6">
            <a href="{{ route('admin.ganado.show', $animal) }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al animal
            </a>
        </div>
    </div>
</x-app-layout>
