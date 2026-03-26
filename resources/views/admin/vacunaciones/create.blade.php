<x-app-layout>
    <x-slot name="title">Nueva Vacunación – {{ $animal->nombre ?? $animal->codigo_nfc }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-bovi-dark flex items-center gap-2">
                <svg class="w-8 h-8 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Nueva Vacunación
            </h2>
            <span class="text-sm text-gray-500 font-medium">
                {{ $animal->nombre ?? $animal->codigo_nfc }}
            </span>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow-md p-4 mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <h3 class="font-bold text-red-800 mb-1">Corrige los siguientes errores:</h3>
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="card-header-green">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Registro de Vacunación
                </h3>
            </div>
            <div class="p-6">
                @include('admin.vacunaciones.form', [
                    'animal'       => $animal,
                    'vaccination'  => new \App\Models\AnimalVaccination(),
                    'action'       => route('animals.vaccinations.store', $animal),
                    'method'       => 'POST',
                ])
            </div>
        </div>

        

        {{-- Leyenda --}}
        <div class="mt-4 rounded-lg p-4 border-l-4 bg-bovi-green-50 border-l-bovi-green-800">
            <p class="text-sm text-gray-700 flex items-center gap-1">
                <svg class="w-5 h-5 text-bovi-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-red-600 font-bold">*</span> = Campo requerido
            </p>
        </div>

    </div>
</x-app-layout>