<x-app-layout>
    <x-slot name="title">Editar sesión de ceba – {{ $animal->nombre ?? $animal->codigo_nfc }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-[var(--green-deep)] flex items-center gap-3">
                <svg class="w-8 h-8 text-[var(--green-mid)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v4a1 1 0 001 1h3m10-6v4a1 1 0 01-1 1h-3M7 21h10M12 3v18"/>
                </svg>
                Editar sesión de ceba
            </h2>
            <span class="text-sm text-gray-500 font-medium">{{ $animal->nombre ?? $animal->codigo_nfc }}</span>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        @include('ceba._form', ['animal' => $animal, 'ceba' => $ceba, 'action' => route('animals.ceba.update', [$animal, $ceba]), 'method' => 'PUT'])
    </div>
</x-app-layout>
