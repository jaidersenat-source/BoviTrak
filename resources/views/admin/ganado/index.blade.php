<x-app-layout>
    <x-slot name="title">Listado de Ganado</x-slot>

    {{-- Fuentes profesionales --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        body, .admin-view { font-family: 'DM Sans', sans-serif; }
        .font-mono-dm { font-family: 'DM Mono', monospace; }

        /* ── Sidebar accent ── */
        .table-row-hover:hover { background-color: #f8f7f5; }
        .table-row-hover:hover td:first-child { border-left: 3px solid #6b7c4e; }
        .table-row-hover td:first-child { border-left: 3px solid transparent; transition: border-color .15s; }

        /* ── Badge sexo ── */
        .badge-hembra { background: #e8f0d8; color: #4a6030; }
        .badge-macho  { background: #dde8f5; color: #2d5080; }

        /* ── Dropdown seguimiento ── */
        .dropdown-menu {
            opacity: 0; pointer-events: none; transform: translateY(6px);
            transition: opacity .18s, transform .18s;
        }
        .dropdown-wrapper:hover .dropdown-menu,
        .dropdown-wrapper:focus-within .dropdown-menu {
            opacity: 1; pointer-events: auto; transform: translateY(0);
        }

        /* ── Action buttons ── */
        .btn-action {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 11px; border-radius: 6px; font-size: .78rem;
            font-weight: 600; transition: all .15s; white-space: nowrap;
        }
        .btn-edit   { background:#e8f0d8; color:#4a6030; }
        .btn-edit:hover   { background:#d4e4b8; }
        .btn-view   { background:#dde8f5; color:#2d5080; }
        .btn-view:hover   { background:#c6d8ef; }
        .btn-delete { background:#fde8e8; color:#9b2c2c; }
        .btn-delete:hover { background:#fcc; }

        /* ── Card mobile ── */
        .card-animal {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #ebe9e4;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
            overflow: hidden;
            transition: box-shadow .2s;
        }
        .card-animal:hover { box-shadow: 0 6px 20px rgba(0,0,0,.1); }
        .card-stripe { height: 4px; background: linear-gradient(90deg, #6b7c4e, #8fa060); }

        /* ── Toast ── */
        @keyframes slideUp {
            from { opacity:0; transform:translateY(12px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .toast-enter { animation: slideUp .3s ease; }

        /* ── Modal backdrop ── */
        .modal-backdrop { backdrop-filter: blur(3px); }
    </style>

    <div class="admin-view min-h-screen bg-[#f5f4f1]">

        {{-- ══════════════ HEADER DE PÁGINA ══════════════ --}}
        <div class="bg-white border-b border-gray-200 px-6 py-5 mb-6">
            <div class="max-w-screen-xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Gestión de Ganado</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Registro y seguimiento del hato bovino</p>
                </div>
                <a href="{{ route('admin.ganado.create') }}"
                   class="inline-flex items-center gap-2 bg-[#5a6e38] hover:bg-[#4a5c2e] text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                    </svg>
                    Registrar Animal
                </a>
            </div>
        </div>

        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 pb-12">

            {{-- ── Alerta éxito simple ── --}}
            @if(session('success') && !session('animal_saved'))
            <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm font-medium rounded-lg px-4 py-3">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
                <button onclick="this.closest('div').remove()" class="ml-auto text-green-500 hover:text-green-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            @endif

            {{-- ══════════════ BUSCADOR + STATS ══════════════ --}}
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
                {{-- Buscador --}}
                <form method="GET" action="{{ route('admin.ganado.index') }}" class="flex gap-2 flex-1">
                    <div class="relative flex-1">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Buscar por NFC, raza o nombre…"
                               class="w-full pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#5a6e38]/30 focus:border-[#5a6e38] placeholder-gray-400">
                    </div>
                    <div>
                        <select name="categoria" class="input-bovi h-10 rounded-lg border border-gray-200 bg-white text-sm pr-8 pl-3">
                            <option value="">Todas las categorías</option>
                            <option value="produccion" {{ request('categoria')=='produccion' ? 'selected' : '' }}>Producción (Leche)</option>
                            <option value="levante" {{ request('categoria')=='levante' ? 'selected' : '' }}>Levante</option>
                            <option value="ceba" {{ request('categoria')=='ceba' ? 'selected' : '' }}>Ceba (Carne)</option>
                        </select>
                    </div>
                    <button type="submit"
                            class="bg-[#5a6e38] hover:bg-[#4a5c2e] text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-colors whitespace-nowrap">
                        Buscar
                    </button>
                    @if(request('search'))
                    <a href="{{ route('admin.ganado.index') }}"
                       class="bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm px-3 py-2.5 rounded-lg transition-colors flex items-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                    @endif
                </form>

                {{-- Conteo --}}
                <div class="flex items-center gap-1.5 bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-500 shrink-0">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="font-semibold text-gray-700">{{ $animals->total() }}</span>
                    <span>animales</span>
                </div>
            </div>

            {{-- ══════════════ TABLA — ESCRITORIO ══════════════ --}}
            <div class="hidden md:block bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                @if($animals->count())
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/80">
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-5 py-3.5 w-16">#</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 py-3.5">Código NFC</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 py-3.5">Raza</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 py-3.5">Categoría</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 py-3.5">Nombre</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 py-3.5">Sexo</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 py-3.5">Enlace público</th>
                            <th class="text-right text-xs font-semibold text-gray-400 uppercase tracking-wider px-5 py-3.5">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($animals as $animal)
                        <tr class="table-row-hover transition-colors">
                            {{-- ID --}}
                            <td class="px-5 py-4 transition-all">
                                <span class="font-mono-dm text-xs font-medium text-gray-400">
                                    {{ str_pad($animal->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            {{-- NFC --}}
                            <td class="px-4 py-4">
                                <span class="font-mono-dm text-sm font-semibold text-gray-800 bg-gray-100 px-2.5 py-1 rounded-md">
                                    {{ $animal->codigo_nfc }}
                                </span>
                            </td>

                            {{-- Raza --}}
                            <td class="px-4 py-4">
                                <span class="font-medium text-gray-700">{{ $animal->raza }}</span>
                            </td>

                            {{-- Categoría --}}
                            <td class="px-4 py-4">
                                @php
                                    $catCode = $animal->categoria ?? $animal->proposito ?? null;
                                    $map = [
                                        'produccion' => ['label' => 'Producción (Leche)', 'class' => 'bg-yellow-50 text-yellow-800'],
                                        'levante' => ['label' => 'Levante', 'class' => 'bg-blue-50 text-blue-800'],
                                        'ceba' => ['label' => 'Ceba (Carne)', 'class' => 'bg-green-50 text-green-800'],
                                        'leche' => ['label' => 'Producción (Leche)', 'class' => 'bg-yellow-50 text-yellow-800'],
                                        'carne' => ['label' => 'Ceba (Carne)', 'class' => 'bg-green-50 text-green-800'],
                                        'doble_proposito' => ['label' => 'Producción (Leche)', 'class' => 'bg-yellow-50 text-yellow-800'],
                                    ];
                                    $cat = $map[$catCode] ?? null;
                                @endphp
                                @if($cat)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $cat['class'] }}">{{ $cat['label'] }}</span>
                                @elseif($catCode)
                                    <span class="text-sm text-gray-500">{{ $catCode }}</span>
                                @else
                                    <span class="text-sm text-gray-400">—</span>
                                @endif
                            </td>

                            {{-- Nombre --}}
                            <td class="px-4 py-4 text-gray-500">
                                {{ $animal->nombre ?? '—' }}
                            </td>

                            {{-- Sexo --}}
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                    {{ strtolower($animal->sexo) === 'hembra' ? 'badge-hembra' : 'badge-macho' }}">
                                    {{ ucfirst($animal->sexo) }}
                                </span>
                            </td>

                            {{-- URL pública --}}
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2 max-w-xs">
                                    <input type="text"
                                           value="{{ route('public.animal.show', $animal->public_token) }}"
                                           readonly
                                           id="url-desk-{{ $animal->id }}"
                                           class="font-mono-dm text-xs text-gray-500 bg-gray-50 border border-gray-200 rounded px-2 py-1 w-full min-w-0 truncate focus:outline-none">
                                    <button onclick="copyToClipboard('url-desk-{{ $animal->id }}')"
                                            title="Copiar URL"
                                            class="shrink-0 p-1.5 rounded text-gray-400 hover:text-[#5a6e38] hover:bg-green-50 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            {{-- Acciones --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-1.5">

                                    {{-- Editar --}}
                                    <a href="{{ route('admin.ganado.edit', $animal->id) }}" class="btn-action btn-edit" title="Editar" aria-label="Editar">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                       
                                    </a>

                                    {{-- Ver --}}
                                    <a href="{{ route('admin.ganado.show', $animal->id) }}" class="btn-action btn-view" title="Ver" aria-label="Ver">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                      
                                    </a>

                                    {{-- Seguimiento dropdown --}}
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" @click.outside="open = false" :aria-expanded="open" class="btn-action bg-amber-50 text-amber-700 hover:bg-amber-100" title="Seguimiento" aria-label="Seguimiento">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            <span class="ml-1"></span>
                                            <svg class="w-3 h-3 ml-2 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>

                                        <div x-show="open"
                                             x-transition:enter="transition ease-out duration-150"
                                             x-transition:enter-start="opacity-0 -translate-y-1"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             x-transition:leave="transition ease-in duration-100"
                                             x-transition:leave-start="opacity-100 translate-y-0"
                                             x-transition:leave-end="opacity-0 -translate-y-1"
                                             @click.outside="open = false"
                                             class="absolute right-0 top-full mt-1.5 w-56 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden"
                                             style="display: none;">
                                            <div class="px-3 py-2 bg-gray-50 border-b border-gray-100">
                                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Seguimiento</p>
                                                <p class="text-xs text-gray-400 font-mono-dm">{{ $animal->codigo_nfc }}</p>
                                            </div>

                                            <div class="py-1">
                                                <a href="{{ route('animals.weights.index', $animal->id) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors">
                                                    <span class="w-6 h-6 rounded-md bg-amber-100 flex items-center justify-center shrink-0">
                                                        <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                                                    </span>
                                                    <span class="font-medium">Registro de Peso</span>
                                                </a>

                                                @if(strtolower($animal->sexo) === 'hembra')
                                                    <a href="{{ route('animals.milk.index', $animal->id) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-sky-50 hover:text-sky-700 transition-colors">
                                                        <span class="w-6 h-6 rounded-md bg-sky-100 flex items-center justify-center shrink-0">
                                                            <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2s5 5.5 5 9a5 5 0 11-10 0c0-3.5 5-9 5-9z"/></svg>
                                                        </span>
                                                        <span class="font-medium">Producción de Leche</span>
                                                    </a>
                                                @endif

                                                <a href="{{ route('animals.vaccinations.index', $animal->id) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                                    <span class="w-6 h-6 rounded-md bg-blue-100 flex items-center justify-center shrink-0">
                                                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                                    </span>
                                                    <span class="font-medium">Vacunación</span>
                                                </a>

                                                <a href="{{ route('animals.health.index', $animal->id) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                                                    <span class="w-6 h-6 rounded-md bg-green-100 flex items-center justify-center shrink-0">
                                                        <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                                    </span>
                                                    <span class="font-medium">Registro Sanitario</span>
                                                </a>

                                                <a href="{{ route('animals.reproductive.index', $animal->id) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-700 transition-colors">
                                                    <span class="w-6 h-6 rounded-md bg-pink-100 flex items-center justify-center shrink-0">
                                                        <svg class="w-3.5 h-3.5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                                    </span>
                                                    <span class="font-medium">Proceso Reproductivo</span>
                                                </a>

                                                <a href="{{ route('animals.descendencia.index', $animal->id) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors">
                                                    <span class="w-6 h-6 rounded-md bg-purple-100 flex items-center justify-center shrink-0">
                                                        <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                    </span>
                                                    <span class="font-medium">Descendencia</span>
                                                </a>

                                                <div class="border-t border-gray-100 my-1"></div>

                                                {{-- Historial Administrativo --}}
                                                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors group">
                                                    <span class="w-7 h-7 rounded-lg bg-gray-100 group-hover:bg-gray-200 flex items-center justify-center flex-shrink-0 transition-colors">
                                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                        </svg>
                                                    </span>
                                                    <div>
                                                        <p class="font-semibold leading-tight">Historial Administrativo</p>
                                                        <p class="text-xs text-gray-400">Leche, carne, crías, sanidad</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                        {{-- Eliminar --}}
                                        <button type="button"
                                            onclick="openDeleteModal({{ $animal->id }}, '{{ $animal->codigo_nfc }}')"
                                            class="btn-action btn-delete" title="Eliminar" aria-label="Eliminar">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        
                                    </button>

                                    {{-- Form oculto eliminar --}}
                                    <form id="delete-form-{{ $animal->id }}" action="{{ route('admin.ganado.destroy', $animal->id) }}" method="POST" class="hidden">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @else
                {{-- Tabla vacía --}}
                <div class="py-20 text-center">
                    <svg class="w-14 h-14 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-lg font-semibold text-gray-400">No hay animales registrados</p>
                    <p class="text-sm text-gray-400 mt-1 mb-6">Comienza agregando el primer animal al sistema</p>
                    <a href="{{ route('admin.ganado.create') }}"
                       class="inline-flex items-center gap-2 bg-[#5a6e38] hover:bg-[#4a5c2e] text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                        </svg>
                        Registrar Animal
                    </a>
                </div>
                @endif
            </div>

            {{-- ══════════════ CARDS — MÓVIL ══════════════ --}}
            <div class="md:hidden space-y-4">
                @forelse($animals as $animal)
                <div class="card-animal">
                    <div class="card-stripe"></div>
                    <div class="p-4">

                        {{-- Fila superior: ID + badge sexo --}}
                        <div class="flex items-center justify-between mb-3">
                            <span class="font-mono-dm text-xs text-gray-400 font-medium">#{{ str_pad($animal->id, 4, '0', STR_PAD_LEFT) }}</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                {{ strtolower($animal->sexo) === 'hembra' ? 'badge-hembra' : 'badge-macho' }}">
                                {{ ucfirst($animal->sexo) }}
                            </span>
                        </div>

                        {{-- NFC --}}
                        <div class="mb-3">
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Código NFC</p>
                            <span class="font-mono-dm text-base font-bold text-gray-800 bg-gray-100 px-2.5 py-1 rounded-md inline-block">
                                {{ $animal->codigo_nfc }}
                            </span>
                        </div>

                        {{-- Raza + Nombre --}}
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Raza</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $animal->raza }}</p>
                            </div>
                            @if($animal->nombre)
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Nombre</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $animal->nombre }}</p>
                            </div>
                            @endif
                        </div>

                        {{-- URL pública --}}
                        <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 mb-4">
                            <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            <input type="text" value="{{ route('public.animal.show', $animal->public_token) }}"
                                   readonly id="url-mob-{{ $animal->id }}"
                                   class="font-mono-dm text-xs text-gray-500 bg-transparent w-full min-w-0 truncate focus:outline-none">
                            <button onclick="copyToClipboard('url-mob-{{ $animal->id }}')"
                                    class="shrink-0 p-1 rounded text-gray-400 hover:text-[#5a6e38] hover:bg-green-50 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>

                        {{-- Acciones principales --}}
                        <div class="grid grid-cols-3 gap-2 mb-2">
                            <a href="{{ route('admin.ganado.edit', $animal->id) }}"
                               class="btn-action btn-edit justify-center text-center py-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Editar
                            </a>
                            <a href="{{ route('admin.ganado.show', $animal->id) }}"
                               class="btn-action btn-view justify-center text-center py-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Ver
                            </a>
                            <button type="button" onclick="openDeleteModal({{ $animal->id }}, '{{ $animal->codigo_nfc }}')"
                                    class="btn-action btn-delete justify-center text-center py-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Eliminar
                            </button>
                        </div>

                        {{-- Seguimiento expandible --}}
                        <div x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="w-full flex items-center justify-between text-sm font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 px-3 py-2 rounded-lg transition-colors">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    Seguimiento
                                </span>
                                <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" x-transition class="mt-2 grid grid-cols-2 gap-2" style="display:none;">
                                <a href="{{ route('animals.weights.index', $animal->id) }}"
                                   class="flex items-center gap-2 px-3 py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-xs font-semibold transition-colors">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                                    Peso
                                </a>
                                @if(strtolower($animal->sexo) === 'hembra')
                                <a href="{{ route('animals.milk.index', $animal->id) }}"
                                   class="flex items-center gap-2 px-3 py-2.5 bg-sky-50 hover:bg-sky-100 text-sky-700 rounded-lg text-xs font-semibold transition-colors">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2s5 5.5 5 9a5 5 0 11-10 0c0-3.5 5-9 5-9z"/></svg>
                                    Leche
                                </a>
                                @endif
                                <a href="{{ route('animals.vaccinations.index', $animal->id) }}"
                                   class="flex items-center gap-2 px-3 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold transition-colors">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    Vacunación
                                </a>
                                <a href="{{ route('animals.health.index', $animal->id) }}"
                                   class="flex items-center gap-2 px-3 py-2.5 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg text-xs font-semibold transition-colors">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    Sanitario
                                </a>
                                <a href="{{ route('animals.reproductive.index', $animal->id) }}"
                                   class="flex items-center gap-2 px-3 py-2.5 bg-pink-50 hover:bg-pink-100 text-pink-700 rounded-lg text-xs font-semibold transition-colors">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    Reproductivo
                                </a>
                                <a href="{{ route('animals.descendencia.index', $animal->id) }}"
                                   class="flex items-center gap-2 px-3 py-2.5 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg text-xs font-semibold transition-colors">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Descendencia
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Form oculto --}}
                    <form id="delete-form-{{ $animal->id }}" action="{{ route('admin.ganado.destroy', $animal->id) }}" method="POST" class="hidden">
                        @csrf @method('DELETE')
                    </form>
                </div>
                @empty
                <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                    <svg class="w-14 h-14 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-base font-semibold text-gray-400 mb-1">No hay animales registrados</p>
                    <p class="text-sm text-gray-400 mb-5">Comienza agregando el primer animal</p>
                    <a href="{{ route('admin.ganado.create') }}"
                       class="inline-flex items-center gap-2 bg-[#5a6e38] hover:bg-[#4a5c2e] text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                        </svg>
                        Registrar Animal
                    </a>
                </div>
                @endforelse
            </div>

            {{-- Paginación --}}
            @if($animals->hasPages())
            <div class="mt-6">
                {{ $animals->links() }}
            </div>
            @endif

        </div>
    </div>

    {{-- ══════════════ MODAL ÉXITO ══════════════ --}}
    @if(session('animal_saved'))
    <div id="successModal" class="hidden fixed inset-0 bg-black/50 modal-backdrop z-50 flex items-center justify-center px-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-7 text-center" id="successModalContent">
            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-1">¡Registro exitoso!</h3>
            <p class="text-sm text-gray-500 mb-5">El animal fue registrado correctamente.</p>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mb-5 text-left grid grid-cols-2 gap-3">
                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-0.5">NFC</p>
                    <p class="font-mono-dm text-sm font-bold text-gray-700">{{ session('animal_saved')['codigo_nfc'] }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Raza</p>
                    <p class="text-sm font-bold text-gray-700">{{ session('animal_saved')['raza'] }}</p>
                </div>
            </div>
            <div class="space-y-2">
                <a href="{{ route('admin.ganado.show', session('animal_saved')['id']) }}"
                   class="block w-full bg-[#5a6e38] hover:bg-[#4a5c2e] text-white text-sm font-semibold py-2.5 rounded-lg transition-colors">
                    Ver detalles
                </a>
                <a href="{{ route('admin.ganado.create') }}"
                   class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-lg transition-colors">
                    Registrar otro
                </a>
                <button onclick="closeSuccessModal()"
                        class="block w-full text-sm text-gray-400 hover:text-gray-600 py-1 transition-colors">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ══════════════ MODAL ELIMINAR ══════════════ --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/50 modal-backdrop z-50 flex items-center justify-center px-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 text-center mb-1">¿Eliminar animal?</h3>
            <p class="text-sm text-gray-500 text-center mb-3">Estás a punto de eliminar permanentemente:</p>
            <div class="bg-red-50 border border-red-200 rounded-lg px-4 py-2.5 mb-4 text-center">
                <span class="font-mono-dm font-bold text-red-700 text-sm" id="animalCode"></span>
            </div>
            <p class="text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2.5 mb-5">
                ⚠️ Esta acción <strong>no se puede deshacer</strong>. Todos los datos asociados se eliminarán permanentemente.
            </p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-lg transition-colors">
                    Cancelar
                </button>
                <button onclick="confirmDelete()"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-2.5 rounded-lg transition-colors shadow-sm">
                    Sí, eliminar
                </button>
            </div>
        </div>
    </div>

    <script>
        let deleteFormId = null;

        document.addEventListener('DOMContentLoaded', () => {
            const m = document.getElementById('successModal');
            if (m) { m.classList.remove('hidden'); }
        });

        function closeSuccessModal() {
            document.getElementById('successModal').classList.add('hidden');
        }

        function openDeleteModal(id, nfc) {
            deleteFormId = id;
            document.getElementById('animalCode').textContent = nfc;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            deleteFormId = null;
        }

        function confirmDelete() {
            if (deleteFormId) {
                document.getElementById('delete-form-' + deleteFormId).submit();
            }
        }

        // Cerrar al clic fuera
        ['successModal','deleteModal'].forEach(id => {
            document.getElementById(id)?.addEventListener('click', function(e) {
                if (e.target === this) {
                    id === 'successModal' ? closeSuccessModal() : closeDeleteModal();
                }
            });
        });

        function copyToClipboard(elementId) {
            const input = document.getElementById(elementId);
            const val = input.value;
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(val).then(() => showToast('URL copiada al portapapeles'));
            } else {
                input.select();
                document.execCommand('copy');
                showToast('URL copiada al portapapeles');
            }
        }

        function showToast(msg) {
            const el = document.createElement('div');
            el.className = 'fixed bottom-5 right-5 bg-gray-800 text-white text-sm font-medium px-4 py-3 rounded-lg shadow-xl flex items-center gap-2.5 z-50 toast-enter';
            el.innerHTML = `<svg class="w-4 h-4 text-green-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>${msg}`;
            document.body.appendChild(el);
            setTimeout(() => { el.style.opacity='0'; el.style.transition='opacity .3s'; setTimeout(()=>el.remove(),300); }, 2200);
        }
    </script>
</x-app-layout>