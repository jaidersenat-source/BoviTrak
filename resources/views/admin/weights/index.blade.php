<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800 leading-tight">
                    Historial de Pesos
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Animal: <span class="font-semibold text-gray-700">{{ $animal->nombre ?? $animal->codigo_nfc }}</span>
                </p>
            </div>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Flash message --}}
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Formulario nuevo peso --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Registrar nuevo peso
                </h3>

                <form method="POST" action="{{ route('animals.weights.store', $animal->id) }}">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- Peso --}}
                        <div>
                            <label for="peso" class="block text-sm font-medium text-gray-700 mb-1">
                                Peso (kg) <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                id="peso"
                                name="peso"
                                step="0.01"
                                min="0.5"
                                max="2000"
                                value="{{ old('peso') }}"
                                placeholder="Ej: 320.50"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('peso') border-red-400 @enderror"
                            >
                            @error('peso')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Fecha --}}
                        <div>
                            <label for="measured_at" class="block text-sm font-medium text-gray-700 mb-1">
                                Fecha de medición <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="date"
                                id="measured_at"
                                name="measured_at"
                                value="{{ old('measured_at', now()->format('Y-m-d')) }}"
                                max="{{ now()->format('Y-m-d') }}"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('measured_at') border-red-400 @enderror"
                            >
                            @error('measured_at')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nota --}}
                        <div class="sm:col-span-2">
                            <label for="nota" class="block text-sm font-medium text-gray-700 mb-1">
                                Nota <span class="text-gray-400 text-xs">(opcional)</span>
                            </label>
                            <textarea
                                id="nota"
                                name="nota"
                                rows="2"
                                placeholder="Condición corporal, observaciones, etc."
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('nota') border-red-400 @enderror"
                            >{{ old('nota') }}</textarea>
                            @error('nota')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Guardar peso
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tabla de historial --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-base font-semibold text-gray-800">Historial de pesajes</h3>
                    <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">
                        {{ $weights->total() }} registros
                    </span>
                </div>

                @if ($weights->isEmpty())
                    <div class="px-6 py-12 text-center text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm">No hay registros de peso aún.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-3 text-left">Fecha</th>
                                    <th class="px-6 py-3 text-left">Peso (kg)</th>
                                    <th class="px-6 py-3 text-left">Variación</th>
                                    <th class="px-6 py-3 text-left">Nota</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($weights as $index => $weight)
                                    @php
                                        $prev = $weights->items()[$index + 1] ?? null;
                                        $diff = $prev ? round($weight->peso - $prev->peso, 2) : null;
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-gray-700 font-medium whitespace-nowrap">
                                            {{ $weight->measured_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">
                                            {{ number_format($weight->peso, 2) }} kg
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($diff !== null)
                                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full
                                                    {{ $diff > 0 ? 'bg-green-100 text-green-700' : ($diff < 0 ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-500') }}">
                                                    {{ $diff > 0 ? '▲' : ($diff < 0 ? '▼' : '—') }}
                                                    {{ $diff !== 0 ? abs($diff) . ' kg' : 'Sin cambio' }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400">—</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-gray-500 max-w-xs truncate">
                                            {{ $weight->nota ?? '—' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($weights->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100">
                            {{ $weights->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>