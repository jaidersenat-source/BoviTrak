<x-app-layout>
    <x-slot name="title">Historial – {{ $animal->nombre ?? $animal->codigo_nfc }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-semibold text-gray-800 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Historial administrativo
            </h2>
            <a href="{{ route('admin.ganado.index') }}"
               class="inline-flex items-center gap-1.5 text-xs text-gray-500 hover:text-gray-700 font-medium transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        {{-- ══ RESUMEN DEL ANIMAL ══ --}}
        <div class="bg-white rounded-xl border border-gray-100 overflow-hidden mb-6">
            <div class="h-1 bg-gradient-to-r from-[#08321f] via-[#3B6D11] to-[#639922]"></div>
            <div class="p-5 flex flex-wrap gap-6 items-center">
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold mb-1">Código NFC</p>
                    <p class="text-lg font-bold font-mono text-gray-800">{{ $animal->codigo_nfc }}</p>
                </div>
                @if($animal->nombre)
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold mb-1">Nombre</p>
                    <p class="text-lg font-semibold text-gray-700">{{ $animal->nombre }}</p>
                </div>
                @endif
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold mb-1">Raza</p>
                    <p class="text-sm text-gray-700">{{ $animal->raza ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold mb-1">Sexo</p>
                    <p class="text-sm text-gray-700">{{ ucfirst($animal->sexo ?? '—') }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold mb-1">Propósito</p>
                    <p class="text-sm text-gray-700">{{ ucfirst($animal->proposito ?? '—') }}</p>
                </div>
                <div class="ml-auto">
                    <a href="{{ route('admin.ganado.show', $animal) }}"
                       class="inline-flex items-center gap-1.5 text-xs font-medium bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-600 px-3 py-1.5 rounded-lg transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver ficha completa
                    </a>
                </div>
            </div>
        </div>

        {{-- ══ ALERTAS ══ --}}
        @if($alertas)
        <div class="mb-6 space-y-2">
            @foreach($alertas as $a)
            @php
                $styles = [
                    'danger'  => ['border' => 'border-red-300',   'bg' => 'bg-red-50',   'text' => 'text-red-700',   'dot' => 'bg-red-400'],
                    'warning' => ['border' => 'border-amber-300', 'bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'dot' => 'bg-amber-400'],
                    'info'    => ['border' => 'border-sky-300',   'bg' => 'bg-sky-50',   'text' => 'text-sky-700',   'dot' => 'bg-sky-400'],
                ];
                $s = $styles[$a['tipo']] ?? $styles['info'];
            @endphp
            <div class="flex items-start gap-3 border-l-4 {{ $s['border'] }} {{ $s['bg'] }} rounded-r-lg px-4 py-3">
                <span class="mt-1.5 w-1.5 h-1.5 rounded-full shrink-0 {{ $s['dot'] }}"></span>
                <span class="text-sm {{ $s['text'] }}">{{ $a['mensaje'] }}</span>
            </div>
            @endforeach
        </div>
        @endif

        {{-- ══ SECCIONES ══ --}}

        @php
        $sections = [
            [
                'titulo'   => 'Registro de peso',
                'ruta'     => route('animals.weights.index', $animal),
                'color'    => 'amber',
                'vacio'    => $animal->weights->isEmpty(),
                'icon'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>',
            ],
        ];
        @endphp

        {{-- PESO --}}
        <section class="mb-5">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <span class="w-5 h-5 rounded-md bg-amber-100 flex items-center justify-center">
                        <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                    </span>
                    Registro de peso
                </h3>
                <a href="{{ route('animals.weights.index', $animal) }}" class="text-xs text-amber-600 hover:text-amber-700 font-medium transition-colors">Ver todos →</a>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                @if($animal->weights->isEmpty())
                    <p class="px-5 py-5 text-xs text-gray-400 text-center">Sin registros de peso.</p>
                @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-[#08321f] text-white text-left text-xs">
                            <th class="px-4 py-2.5 font-medium">Fecha</th>
                            <th class="px-4 py-2.5 font-medium">Peso (kg)</th>
                            <th class="px-4 py-2.5 font-medium">Nota</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($animal->weights->sortByDesc('measured_at')->take(8) as $w)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-2.5 text-gray-600 text-xs">{{ \Carbon\Carbon::parse($w->measured_at)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2.5 font-semibold text-amber-700">{{ $w->peso }} <span class="font-normal text-gray-400 text-xs">kg</span></td>
                            <td class="px-4 py-2.5 text-gray-400 text-xs">{{ $w->nota ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </section>

        {{-- VACUNACIONES --}}
        <section class="mb-5">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <span class="w-5 h-5 rounded-md bg-blue-100 flex items-center justify-center">
                        <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </span>
                    Vacunaciones
                </h3>
                <a href="{{ route('animals.vaccinations.index', $animal) }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium transition-colors">Ver todos →</a>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                @if($animal->vaccinations->isEmpty())
                    <p class="px-5 py-5 text-xs text-gray-400 text-center">Sin vacunaciones registradas.</p>
                @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-[#08321f] text-white text-left text-xs">
                            <th class="px-4 py-2.5 font-medium">Vacuna</th>
                            <th class="px-4 py-2.5 font-medium">Dosis</th>
                            <th class="px-4 py-2.5 font-medium">Fecha</th>
                            <th class="px-4 py-2.5 font-medium">Lote</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($animal->vaccinations->sortByDesc('fecha_vacunacion')->take(8) as $v)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-2.5 font-medium text-gray-800 text-xs">{{ $v->vacuna }}</td>
                            <td class="px-4 py-2.5 text-gray-500 text-xs">{{ $v->dosis }}</td>
                            <td class="px-4 py-2.5 text-gray-600 text-xs">{{ \Carbon\Carbon::parse($v->fecha_vacunacion)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2.5 text-gray-400 text-xs">{{ $v->lote ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </section>

        {{-- SANITARIO --}}
        <section class="mb-5">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <span class="w-5 h-5 rounded-md bg-green-100 flex items-center justify-center">
                        <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </span>
                    Registro sanitario
                </h3>
                <a href="{{ route('animals.health.index', $animal) }}" class="text-xs text-green-700 hover:text-green-800 font-medium transition-colors">Ver todos →</a>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                @if($animal->healthRecords->isEmpty())
                    <p class="px-5 py-5 text-xs text-gray-400 text-center">Sin registros sanitarios.</p>
                @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-[#08321f] text-white text-left text-xs">
                            <th class="px-4 py-2.5 font-medium">Tipo</th>
                            <th class="px-4 py-2.5 font-medium">Fecha lavado</th>
                            <th class="px-4 py-2.5 font-medium">Producto</th>
                            <th class="px-4 py-2.5 font-medium">Fecha purga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($animal->healthRecords->sortByDesc('fecha_lavado')->take(8) as $h)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-2.5">
                                <span class="inline-block text-[10px] font-semibold bg-green-50 text-green-700 border border-green-200 px-2 py-0.5 rounded-full">{{ $h->tipo }}</span>
                            </td>
                            <td class="px-4 py-2.5 text-gray-600 text-xs">{{ $h->fecha_lavado ? $h->fecha_lavado->format('d/m/Y') : '—' }}</td>
                            <td class="px-4 py-2.5 text-gray-500 text-xs">{{ $h->producto_lavado ?? '—' }}</td>
                            <td class="px-4 py-2.5 text-gray-600 text-xs">{{ $h->fecha_purga ? $h->fecha_purga->format('d/m/Y') : '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </section>

        {{-- REPRODUCTIVO (solo hembras) --}}
        @if(strtolower($animal->sexo ?? '') === 'hembra')
        <section class="mb-5">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <span class="w-5 h-5 rounded-md bg-pink-100 flex items-center justify-center">
                        <svg class="w-3 h-3 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </span>
                    Proceso reproductivo
                </h3>
                <a href="{{ route('animals.reproductive.index', $animal) }}" class="text-xs text-pink-600 hover:text-pink-700 font-medium transition-colors">Ver todos →</a>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                @if($animal->reproductiveRecords->isEmpty())
                    <p class="px-5 py-5 text-xs text-gray-400 text-center">Sin procesos reproductivos registrados.</p>
                @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-[#08321f] text-white text-left text-xs">
                            <th class="px-4 py-2.5 font-medium">Tipo proceso</th>
                            <th class="px-4 py-2.5 font-medium">F. inserción</th>
                            <th class="px-4 py-2.5 font-medium">F. preñez</th>
                            <th class="px-4 py-2.5 font-medium">Parto estimado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($animal->reproductiveRecords->sortByDesc('fecha_insercion')->take(8) as $r)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-2.5 font-medium text-gray-800 text-xs">{{ $r->tipo_proceso_label }}</td>
                            <td class="px-4 py-2.5 text-gray-600 text-xs">{{ $r->fecha_insercion ? $r->fecha_insercion->format('d/m/Y') : '—' }}</td>
                            <td class="px-4 py-2.5 text-gray-600 text-xs">{{ $r->fecha_prenez ? $r->fecha_prenez->format('d/m/Y') : '—' }}</td>
                            <td class="px-4 py-2.5 text-xs">
                                @if($r->fecha_estimada_parto)
                                    <span class="{{ $r->fecha_estimada_parto->isFuture() ? 'text-pink-600 font-semibold' : 'text-gray-600' }}">
                                        {{ $r->fecha_estimada_parto->format('d/m/Y') }}
                                    </span>
                                    @if($r->fecha_estimada_parto->isFuture())
                                        <span class="text-[10px] text-pink-400 ml-1">en {{ $r->fecha_estimada_parto->diffInDays(now()) }}d</span>
                                    @endif
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </section>
        @endif

        {{-- CEBA --}}
        <section class="mb-5">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <span class="w-5 h-5 rounded-md bg-red-100 flex items-center justify-center">
                        <svg class="w-3 h-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v4a1 1 0 001 1h3m10-6v4a1 1 0 01-1 1h-3M7 21h10M12 3v18"/></svg>
                    </span>
                    Proceso de ceba
                </h3>
                <a href="{{ route('animals.ceba.index', $animal) }}" class="text-xs text-red-600 hover:text-red-700 font-medium transition-colors">Ver todos →</a>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                @if($animal->cebas->isEmpty())
                    <p class="px-5 py-5 text-xs text-gray-400 text-center">Sin sesiones de ceba registradas.</p>
                @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-[#08321f] text-white text-left text-xs">
                            <th class="px-4 py-2.5 font-medium">Ingreso</th>
                            <th class="px-4 py-2.5 font-medium">Peso inicial</th>
                            <th class="px-4 py-2.5 font-medium">Objetivo</th>
                            <th class="px-4 py-2.5 font-medium">Registros</th>
                            <th class="px-4 py-2.5 font-medium">Alimento total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($animal->cebas as $c)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-2.5 text-gray-600 text-xs">{{ $c->fecha_ingreso ? \Carbon\Carbon::parse($c->fecha_ingreso)->format('d/m/Y') : '—' }}</td>
                            <td class="px-4 py-2.5 font-semibold text-yellow-700 text-xs">{{ $c->peso_inicial ?? '—' }} <span class="font-normal text-gray-400">kg</span></td>
                            <td class="px-4 py-2.5 text-gray-500 text-xs">{{ $c->peso_objetivo ?? '—' }} <span class="text-gray-400">kg</span></td>
                            <td class="px-4 py-2.5 text-gray-500 text-xs">{{ $c->registros->count() }}</td>
                            <td class="px-4 py-2.5 text-gray-500 text-xs">{{ number_format($c->registros->sum('cantidad_alimento'), 2) }} <span class="text-gray-400">kg</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </section>

        {{-- DESCENDENCIA --}}
        <section class="mb-5">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <span class="w-5 h-5 rounded-md bg-purple-100 flex items-center justify-center">
                        <svg class="w-3 h-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </span>
                    Descendencia
                </h3>
                <a href="{{ route('animals.descendencia.index', $animal) }}" class="text-xs text-purple-600 hover:text-purple-700 font-medium transition-colors">Ver todos →</a>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                @if($animal->descendances->isEmpty())
                    <p class="px-5 py-5 text-xs text-gray-400 text-center">Sin registros de descendencia.</p>
                @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-[#08321f] text-white text-left text-xs">
                            <th class="px-4 py-2.5 font-medium">F. nacimiento</th>
                            <th class="px-4 py-2.5 font-medium">Padre</th>
                            <th class="px-4 py-2.5 font-medium">Madre</th>
                            <th class="px-4 py-2.5 font-medium">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($animal->descendances->sortByDesc('fecha_nacimiento')->take(8) as $d)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-2.5 font-medium text-gray-800 text-xs">{{ $d->fecha_nacimiento ? $d->fecha_nacimiento->format('d/m/Y') : '—' }}</td>
                            <td class="px-4 py-2.5 text-gray-500 text-xs font-mono">{{ $d->padre->codigo_nfc ?? ($d->padre->nombre ?? '—') }}</td>
                            <td class="px-4 py-2.5 text-gray-500 text-xs font-mono">{{ $d->madre->codigo_nfc ?? ($d->madre->nombre ?? '—') }}</td>
                            <td class="px-4 py-2.5 text-gray-400 text-xs">{{ $d->observaciones ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </section>

    </div>
</x-app-layout>