@php
    $action = route('admin.lotes.update', $lote);
    $method = 'PUT';
@endphp

<x-app-layout>
    <x-slot name="title">Editar Lote</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-bovi-dark flex items-center gap-2">
                <svg class="w-8 h-8 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7"/>
                </svg>
                Editar Lote
            </h2>
            <span class="text-sm text-gray-500 font-medium bg-gray-100 px-3 py-1 rounded-full">Editar</span>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6">
                @include('admin.lotes.form', [
                    'lote' => $lote,
                    'action' => $action,
                    'method' => $method,
                ])
            </div>
        </div>
    </div>
</x-app-layout>
