<x-app-layout>
    <x-slot name="title">Nuevo Registro Sanitario – {{ $animal->nombre ?? $animal->codigo_nfc }}</x-slot>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 leading-tight tracking-tight">
                    Nuevo Registro Sanitario
                </h2>
                <div class="flex items-center gap-2 mt-1.5">
                    <p class="text-sm text-gray-500">Animal:</p>
                    <span class="font-medium text-gray-700">{{ $animal->nombre ?? $animal->codigo_nfc }}</span>
                    @if($animal->proposito)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ in_array($animal->proposito, ['carne','ceba','levante'])
                                ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'
                                : 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' }}">
                            {{ ucfirst($animal->proposito) }}
                        </span>
                    @endif
                </div>
            </div>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 bg-white border border-gray-200 hover:border-gray-300 px-3.5 py-2 rounded-lg transition-all duration-150">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-5">

        {{-- Errores --}}
        @if ($errors->any())
            <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3.5">
                <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-red-800 mb-1">Corrige los siguientes errores:</p>
                    <ul class="text-xs text-red-700 space-y-0.5 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Aviso informativo --}}
        <div class="flex items-start gap-3 bg-blue-50 border border-blue-200 rounded-xl px-4 py-3.5">
            <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-blue-700">
                Puedes registrar <strong>Lavado</strong>, <strong>Purga</strong> o <strong>ambos</strong> en el mismo registro. Al menos una sección debe estar completa.
            </p>
        </div>

        {{-- Selector individual / lote --}}
        <div class="flex items-center gap-2 p-1 bg-gray-100 rounded-xl w-fit">
            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-semibold text-gray-800 shadow-sm cursor-default">
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Este animal
            </span>
            <a href="{{ route('animals.health.batch.create', $animal) }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-medium text-gray-500 hover:text-gray-800 hover:bg-white hover:border hover:border-gray-200 transition-all duration-150">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Por lote
            </a>
        </div>

        {{-- Formulario --}}
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <div class="flex items-center gap-2.5 px-5 py-4 border-b border-gray-100">
                <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-gray-800">Registro Sanitario</h3>
            </div>
            <div class="p-5">
                @include('admin.sanitario.form', [
                    'animal'  => $animal,
                    'health'  => new \App\Models\AnimalHealthRecord(),
                    'action'  => route('animals.health.store', $animal),
                    'method'  => 'POST',
                ])
            </div>
        </div>

    </div>
</x-app-layout>