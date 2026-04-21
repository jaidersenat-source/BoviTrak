<x-app-layout>
    <x-slot name="title">Ceba – {{ $animal->nombre ?? $animal->codigo_nfc }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-[var(--green-deep)] flex items-center gap-3">
                <svg class="w-8 h-8 text-[var(--green-mid)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v4a1 1 0 001 1h3m10-6v4a1 1 0 01-1 1h-3M7 21h10M12 3v18"/>
                </svg>
                Ceba
            </h2>
            <span class="text-sm text-gray-500 font-medium">{{ $animal->nombre ?? $animal->codigo_nfc }}</span>
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

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-8 bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="card-header-green text-white text-left">
                                <th class="px-5 py-3 font-semibold">Fecha</th>
                                <th class="px-5 py-3 font-semibold">Peso (kg)</th>
                                <th class="px-5 py-3 font-semibold">Alimento</th>
                                <th class="px-5 py-3 font-semibold">Cantidad (kg)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($registros as $r)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-5 py-4 text-gray-800">{{ $r->medido_el ? \Carbon\Carbon::parse($r->medido_el)->format('d/m/Y H:i') : '—' }}</td>
                                    <td class="px-5 py-4 text-gray-600">{{ $r->peso ?? '—' }}</td>
                                    <td class="px-5 py-4 text-gray-600">{{ $r->tipo_alimento ?? '—' }}</td>
                                    <td class="px-5 py-4 text-gray-600">{{ $r->cantidad_alimento ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-6 text-sm text-[var(--text-muted)] text-center">Sin registros</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <aside class="lg:col-span-4">
                <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-4">
                    <h3 class="font-semibold mb-2">Evaluación</h3>
                    <div class="text-sm">
                        <div>ADG (kg/día): <strong>{{ $adg ? number_format($adg, 3, ',', '.') : '—' }}</strong></div>
                        <div>Eficiencia (kg ganado / kg alimento): <strong>{{ $eficiencia ? number_format($eficiencia, 3, ',', '.') : '—' }}</strong></div>
                        <div class="mt-2 text-[var(--text-muted)] text-xs">ADG calculado entre el primer y último registro; eficiencia basada en alimento reportado.</div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
                    <h4 class="font-semibold mb-3">Agregar registro</h4>
                    <form method="POST" action="{{ route('animals.ceba.registros.store', [$animal, $ceba]) }}" class="space-y-3">
                        @csrf
                        <div>
                            <label class="label-bovi">Fecha</label>
                            <input type="datetime-local" name="medido_el" class="input-bovi" />
                        </div>
                        <div>
                            <label class="label-bovi">Peso (kg)</label>
                            <input type="number" step="0.1" name="peso" class="input-bovi" />
                        </div>
                        <div>
                            <label class="label-bovi">Tipo de alimento</label>
                            <input type="text" name="tipo_alimento" class="input-bovi" />
                        </div>
                        <div>
                            <label class="label-bovi">Cantidad alimento (kg)</label>
                            <input type="number" step="0.01" name="cantidad_alimento" class="input-bovi" />
                        </div>
                        <div>
                            <label class="label-bovi">Observaciones</label>
                            <textarea name="observaciones" class="textarea-bovi" rows="3"></textarea>
                        </div>
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('animals.ceba.index', $animal) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-lg">Volver</a>
                            <button class="btn-bovi-gradient px-4 py-2.5 rounded-lg">Agregar</button>
                        </div>
                    </form>
                </div>
            </aside>
        </div>

    </div>
</x-app-layout>
