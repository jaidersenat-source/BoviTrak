<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 leading-tight tracking-tight">
                    Historial de Pesos
                </h2>
                <div class="flex items-center gap-2 mt-1.5">
                    <p class="text-sm text-gray-500">
                        Animal: <span class="font-medium text-gray-700">{{ $animal->nombre ?? $animal->codigo_nfc }}</span>
                    </p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ in_array($animal->proposito, ['carne','ceba','levante'])
                            ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'
                            : 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' }}">
                        {{ ucfirst($animal->proposito) }}
                    </span>
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

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash message --}}
            @if (session('success'))
                <div class="flex items-center gap-2.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm">
                    <svg class="w-4 h-4 shrink-0 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Formulario nuevo peso --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">

                <div class="flex items-center gap-2.5 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-50">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800">Registrar nuevo peso</h3>
                </div>

                <div class="p-6">

                    {{-- Alerta de frecuencia según categoría --}}
                    @if(in_array($animal->proposito, ['carne','ceba','levante','doble_proposito']))
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-2 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 mb-5">
                            <svg class="w-4 h-4 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-xs font-medium">El registro de peso es <strong>obligatorio</strong> para esta categoría.</span>
                            <form method="POST" action="{{ route('animals.weights.setFrequency', $animal->id) }}" class="flex items-center gap-2 ml-auto">
                                @csrf
                                <label for="frecuencia" class="text-xs text-emerald-700">Frecuencia:</label>
                                    <select name="frecuencia" id="frecuencia"
                                        class="text-xs rounded-lg border border-emerald-300 bg-white text-emerald-800 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 py-1 pl-2 pr-6">
                                        <option value="mensual" {{ $animal->frecuencia_peso === 'mensual' ? 'selected' : '' }}>Mensual</option>
                                        <option value="quincenal" {{ $animal->frecuencia_peso === 'quincenal' ? 'selected' : '' }}>Quincenal</option>
                                    </select>
                                    <button type="submit" class="ml-2 text-xs font-semibold text-emerald-700 bg-emerald-100 px-2 py-1 rounded-lg hover:bg-emerald-200">Guardar</button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center gap-2.5 bg-blue-50 border border-blue-200 text-blue-800 rounded-xl px-4 py-3 mb-5">
                            <svg class="w-4 h-4 shrink-0 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-xs font-medium">El registro de peso es <strong>opcional</strong> para esta categoría.</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('animals.weights.store', $animal->id) }}">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            {{-- Peso --}}
                            <div>
                                <label for="peso" class="block text-xs font-medium text-gray-600 mb-1.5">
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
                                    class="w-full rounded-xl border bg-gray-50 border-gray-200 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400
                                        focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white transition-all
                                        @error('peso') @enderror"
                                >
                                @error('peso')
                                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Fecha --}}
                            <div>
                                <label for="measured_at" class="block text-xs font-medium text-gray-600 mb-1.5">
                                    Fecha de medición <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="date"
                                    id="measured_at"
                                    name="measured_at"
                                    value="{{ old('measured_at', now()->format('Y-m-d')) }}"
                                    max="{{ now()->format('Y-m-d') }}"
                                    class="w-full rounded-xl border bg-gray-50 border-gray-200 px-3.5 py-2.5 text-sm text-gray-900
                                        focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white transition-all
                                        @error('measured_at') @enderror"
                                >
                                @error('measured_at')
                                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Nota --}}
                            <div class="sm:col-span-2">
                                <label for="nota" class="block text-xs font-medium text-gray-600 mb-1.5">
                                    Nota <span class="text-gray-400 font-normal">(opcional)</span>
                                </label>
                                <textarea
                                    id="nota"
                                    name="nota"
                                    rows="2"
                                    placeholder="Condición corporal, observaciones, etc."
                                    class="w-full rounded-xl border bg-gray-50 border-gray-200 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 resize-none
                                        focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white transition-all
                                        @error('nota') @enderror"
                                >{{ old('nota') }}</textarea>
                                @error('nota')
                                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors duration-150 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Guardar peso
                            </button>
                        </div>
                    </form>
                    <script>
                        // auto-submit frecuencia select para mejorar UX
                        (function(){
                            const sel = document.getElementById('frecuencia');
                            if (!sel) return;
                            sel.addEventListener('change', function(){
                                const f = sel.closest('form');
                                if (f) f.submit();
                            });
                        })();
                    </script>
                </div>
            </div>

            {{-- Tabla de historial --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-800">Historial de pesajes</h3>
                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
                        {{ $weights->total() }} {{ $weights->total() === 1 ? 'registro' : 'registros' }}
                    </span>
                </div>

                @if ($weights->isEmpty())
                    <div class="flex flex-col items-center justify-center px-6 py-16 text-center">
                        <div class="w-12 h-12 rounded-2xl bg-gray-50 border border-gray-200 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-700">Sin registros aún</p>
                        <p class="text-xs text-gray-400 mt-1">Los pesajes registrados aparecerán aquí.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Peso</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Variación</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nota</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($weights as $index => $weight)
                                    @php
                                        $prev = $weights->items()[$index + 1] ?? null;
                                        $diff = $prev ? round($weight->peso - $prev->peso, 2) : null;
                                    @endphp
                                    <tr class="hover:bg-gray-50/70 transition-colors duration-100">
                                        <td class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap">
                                            {{ $weight->measured_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-base font-semibold text-gray-900">{{ number_format($weight->peso, 2) }}</span>
                                            <span class="text-xs text-gray-400 ml-0.5">kg</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($diff !== null)
                                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full
                                                    {{ $diff > 0
                                                        ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'
                                                        : ($diff < 0
                                                            ? 'bg-red-50 text-red-700 ring-1 ring-red-200'
                                                            : 'bg-gray-100 text-gray-500') }}">
                                                    @if($diff > 0)
                                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                                    @elseif($diff < 0)
                                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                                    @endif
                                                    {{ $diff !== 0 ? abs($diff) . ' kg' : 'Sin cambio' }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-300">—</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-gray-500 max-w-xs">
                                            <span class="block truncate">{{ $weight->nota ?? '—' }}</span>
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