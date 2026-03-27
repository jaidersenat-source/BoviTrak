@php
    $action = route('animals.milk.update', [$animal, $record]);
    $method = 'PUT';
@endphp

<x-app-layout>
    <x-slot name="title">Editar Registro de Producción – {{ $animal->nombre ?? $animal->codigo_nfc }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-bovi-dark flex items-center gap-2">
                <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2s5 5.5 5 9a5 5 0 11-10 0c0-3.5 5-9 5-9z" />
                </svg>
                Editar Registro de Producción
            </h2>
            <span class="text-sm text-gray-500 font-medium bg-gray-100 px-3 py-1 rounded-full">
                {{ $animal->nombre ?? $animal->codigo_nfc }}
            </span>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="card-header-sky">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    Editar Registro
                </h3>
            </div>
            <div class="p-6">
                @include('admin.milk.form', [
                    'animal' => $animal,
                    'record' => $record,
                    'action' => $action,
                    'method' => $method,
                ])
            </div>
        </div>
    </div>
</x-app-layout>
