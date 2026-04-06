<x-app-layout>
    <x-slot name="title">Lotes</x-slot>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --green-deep:  #3d5228;
            --green-mid:   #5a6e38;
            --green-light: #8fa060;
            --green-pale:  #eef3e6;
            --amber:       #c07d2a;
            --amber-pale:  #fdf3e3;
            --sky:         #1d6fa4;
            --sky-pale:    #e2f0fb;
            --rose:        #a83244;
            --rose-pale:   #fce8ec;
            --sand:        #f7f5f1;
            --border:      #e8e5df;
            --text-main:   #1e2318;
            --text-muted:  #7a7d72;
        }
        .lotes-view * { font-family: 'DM Sans', sans-serif; }
        .mono { font-family: 'DM Mono', monospace; }

        /* Table */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead tr {
            background: #fafaf8;
            border-bottom: 1px solid var(--border);
        }
        .data-table th {
            text-align: left;
            font-size: .68rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .08em;
            color: var(--text-muted);
            padding: 12px 16px;
            white-space: nowrap;
        }
        .data-table tbody tr {
            border-bottom: 1px solid #f2f0ec;
            transition: background .12s;
        }
        .data-table tbody tr:last-child { border-bottom: none; }
        .data-table tbody tr:hover { background: #fafaf8; }
        .data-table tbody tr:hover td:first-child { border-left: 3px solid var(--green-mid); }
        .data-table tbody tr td:first-child { border-left: 3px solid transparent; transition: border-color .12s; }
        .data-table td {
            padding: 13px 16px;
            font-size: .84rem;
            color: var(--text-main);
            vertical-align: middle;
        }

        /* Días badge */
        .dias-chip {
            display: inline-flex; align-items: center; gap: 4px;
            background: var(--sand); border: 1px solid var(--border);
            border-radius: 6px; padding: 2px 8px;
            font-size: .75rem; font-weight: 500; color: var(--text-muted);
        }
        .dias-chip strong { color: var(--text-main); font-weight: 700; }

        /* Area badge */
        .area-chip {
            display: inline-flex; align-items: center; gap: 3px;
            font-family: 'DM Mono', monospace;
            font-size: .78rem; font-weight: 500;
            color: var(--green-deep);
            background: var(--green-pale);
            border-radius: 6px; padding: 2px 8px;
        }

        /* Action buttons */
        .btn-act {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 5px 10px; border-radius: 7px;
            font-size: .75rem; font-weight: 600;
            transition: background .12s, color .12s;
            white-space: nowrap; text-decoration: none;
        }
        .btn-ver    { background: var(--sky-pale);   color: var(--sky);  }
        .btn-ver:hover    { background: #c6d8ef; }
        .btn-edit   { background: var(--amber-pale); color: var(--amber); }
        .btn-edit:hover   { background: #f5e0bb; }
        .btn-del    { background: var(--rose-pale);  color: var(--rose); border: none; cursor: pointer; }
        .btn-del:hover    { background: #f9c8d0; }

        /* Fade-up */
        @keyframes fadeUp { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
        .fade-up { animation: fadeUp .35s ease both; }
        .d1{animation-delay:.05s} .d2{animation-delay:.1s} .d3{animation-delay:.15s}

        /* Modal */
        .modal-backdrop { backdrop-filter: blur(3px); }
    </style>

    <div class="lotes-view min-h-screen bg-[var(--sand)]">

        {{-- ══ PAGE HEADER ══ --}}
        <div class="bg-white border-b border-[var(--border)] px-6 py-5 mb-6 fade-up d1">
            <div class="max-w-screen-xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-[var(--text-main)] tracking-tight">Gestión de Lotes</h1>
                    <p class="text-sm text-[var(--text-muted)] mt-0.5">Control de pasturas y tiempos de rotación</p>
                </div>
                <a href="{{ route('admin.lotes.create') }}"
                   class="inline-flex items-center gap-2 bg-[var(--green-mid)] hover:bg-[var(--green-deep)] text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                    </svg>
                    Nuevo Lote
                </a>
            </div>
        </div>

        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 pb-12">

            {{-- Alerta éxito --}}
            @if(session('success'))
            <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm font-medium rounded-lg px-4 py-3 fade-up d1">
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

            @if($lotes->isEmpty())
            {{-- ══ ESTADO VACÍO ══ --}}
            <div class="bg-white rounded-xl border border-[var(--border)] shadow-sm py-20 text-center fade-up d2">
                <svg class="w-14 h-14 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7h18M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7"/>
                </svg>
                <p class="text-base font-semibold text-[var(--text-muted)] mb-1">No hay lotes registrados</p>
                <p class="text-sm text-[var(--text-muted)] mb-6">Crea el primer lote para organizar el manejo de pasturas.</p>
                <a href="{{ route('admin.lotes.create') }}"
                   class="inline-flex items-center gap-2 bg-[var(--green-mid)] hover:bg-[var(--green-deep)] text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                    </svg>
                    Agregar Lote
                </a>
            </div>

            @else

            {{-- ══ STATS RÁPIDAS ══ --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5 fade-up d1">
                <div class="bg-white border border-[var(--border)] rounded-xl px-4 py-3.5">
                    <p class="text-xs text-[var(--text-muted)] font-semibold uppercase tracking-wider mb-1">Total lotes</p>
                    <p class="text-2xl font-bold text-[var(--text-main)] mono">{{ $lotes->total() }}</p>
                </div>
                <div class="bg-white border border-[var(--border)] rounded-xl px-4 py-3.5">
                    <p class="text-xs text-[var(--text-muted)] font-semibold uppercase tracking-wider mb-1">Área total</p>
                    <p class="text-2xl font-bold text-[var(--green-deep)] mono">
                        {{ number_format($lotes->sum('area_ha'), 1) }}
                        <span class="text-sm font-normal text-[var(--text-muted)]">ha</span>
                    </p>
                </div>
                <div class="bg-white border border-[var(--border)] rounded-xl px-4 py-3.5">
                    <p class="text-xs text-[var(--text-muted)] font-semibold uppercase tracking-wider mb-1">Ocup. promedio</p>
                    <p class="text-2xl font-bold text-[var(--amber)] mono">
                        {{ number_format($lotes->avg('tiempo_ocupacion_dias'), 0) }}
                        <span class="text-sm font-normal text-[var(--text-muted)]">días</span>
                    </p>
                </div>
                <div class="bg-white border border-[var(--border)] rounded-xl px-4 py-3.5">
                    <p class="text-xs text-[var(--text-muted)] font-semibold uppercase tracking-wider mb-1">Descanso prom.</p>
                    <p class="text-2xl font-bold text-[var(--sky)] mono">
                        {{ number_format($lotes->avg('tiempo_descanso_dias'), 0) }}
                        <span class="text-sm font-normal text-[var(--text-muted)]">días</span>
                    </p>
                </div>
            </div>

            {{-- ══ TABLA ESCRITORIO ══ --}}
            <div class="hidden md:block bg-white rounded-xl border border-[var(--border)] shadow-sm overflow-hidden fade-up d2">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Pastura</th>
                            <th>Área</th>
                            <th>Ocupación</th>
                            <th>Descanso</th>
                            <th>Registrado por</th>
                            <th class="text-right pr-5">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lotes as $lote)
                        <tr>
                            {{-- Código --}}
                            <td>
                                <span class="mono text-sm font-semibold text-[var(--text-main)] bg-[var(--sand)] border border-[var(--border)] px-2.5 py-1 rounded-md inline-block">
                                    {{ $lote->codigo }}
                                </span>
                                @if(!empty($lote->is_resting) && $lote->is_resting)
                                    <div class="mt-2">
                                        <span class="text-xs bg-red-50 text-red-700 px-2 py-1 rounded">Descanso hasta {{ $lote->rest_until->format('d/m/Y') }} ({{ number_format(round($lote->dias_restantes ?? 0), 0) }} días)</span>
                                    </div>
                                @endif
                            </td>

                            {{-- Pastura --}}
                            <td class="font-medium text-[var(--text-main)]">{{ $lote->nombre_pastura }}</td>

                            {{-- Área --}}
                            <td>
                                @if($lote->area_ha)
                                    <span class="area-chip">{{ number_format($lote->area_ha, 1) }} ha</span>
                                @else
                                    <span class="text-[var(--text-muted)]">—</span>
                                @endif
                            </td>

                            {{-- Ocupación --}}
                            <td>
                                @if($lote->tiempo_ocupacion_dias)
                                    <span class="dias-chip">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <strong>{{ $lote->tiempo_ocupacion_dias }}</strong> días
                                    </span>
                                @else
                                    <span class="text-[var(--text-muted)]">—</span>
                                @endif
                            </td>

                            {{-- Descanso --}}
                            <td>
                                @if($lote->tiempo_descanso_dias)
                                    <span class="dias-chip">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                        </svg>
                                        <strong>{{ $lote->tiempo_descanso_dias }}</strong> días
                                    </span>
                                @else
                                    <span class="text-[var(--text-muted)]">—</span>
                                @endif
                            </td>

                            {{-- Usuario --}}
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-md bg-[var(--green-pale)] flex items-center justify-center text-[var(--green-deep)] text-xs font-bold shrink-0">
                                        {{ substr($lote->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <span class="text-sm text-[var(--text-muted)]">{{ $lote->user->name ?? '—' }}</span>
                                </div>
                            </td>

                            {{-- Acciones --}}
                            <td class="pr-5">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.lotes.show', $lote) }}" class="btn-act btn-ver">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Ver
                                    </a>
                                    <a href="{{ route('admin.lotes.edit', $lote) }}" class="btn-act btn-edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    <button type="button"
                                            onclick="openDeleteModal({{ $lote->id }}, '{{ $lote->codigo }}')"
                                            class="btn-act btn-del">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Eliminar
                                    </button>
                                    <form id="del-{{ $lote->id }}" action="{{ route('admin.lotes.destroy', $lote) }}" method="POST" class="hidden">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ══ CARDS MÓVIL ══ --}}
            <div class="md:hidden space-y-3 fade-up d2">
                @foreach($lotes as $lote)
                <div class="bg-white rounded-xl border border-[var(--border)] overflow-hidden shadow-sm">
                    <div class="h-1" style="background: linear-gradient(90deg, var(--green-mid), var(--green-light))"></div>
                    <div class="p-4">
                        {{-- Código + acciones rápidas --}}
                        <div class="flex items-start justify-between mb-3">
                            <span class="mono text-sm font-bold text-[var(--text-main)] bg-[var(--sand)] border border-[var(--border)] px-2.5 py-1 rounded-md">
                                {{ $lote->codigo }}
                            </span>
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('admin.lotes.show', $lote) }}" class="btn-act btn-ver">Ver</a>
                                <a href="{{ route('admin.lotes.edit', $lote) }}" class="btn-act btn-edit">Editar</a>
                                <button onclick="openDeleteModal({{ $lote->id }}, '{{ $lote->codigo }}')" class="btn-act btn-del">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Nombre pastura --}}
                        <p class="text-base font-semibold text-[var(--text-main)] mb-3">{{ $lote->nombre_pastura }}</p>

                        {{-- Métricas en grid --}}
                        <div class="grid grid-cols-3 gap-2 mb-3">
                            <div class="bg-[var(--green-pale)] rounded-lg px-3 py-2 text-center">
                                <p class="text-xs text-[var(--green-deep)] font-semibold uppercase tracking-wider mb-0.5">Área</p>
                                <p class="mono text-sm font-bold text-[var(--green-deep)]">{{ $lote->area_ha ? number_format($lote->area_ha, 1) : '—' }}<span class="text-xs font-normal"> ha</span></p>
                            </div>
                            <div class="bg-[var(--amber-pale)] rounded-lg px-3 py-2 text-center">
                                <p class="text-xs text-[var(--amber)] font-semibold uppercase tracking-wider mb-0.5">Ocup.</p>
                                <p class="mono text-sm font-bold text-[var(--amber)]">{{ $lote->tiempo_ocupacion_dias ?? '—' }}<span class="text-xs font-normal"> d</span></p>
                            </div>
                            <div class="bg-[var(--sky-pale)] rounded-lg px-3 py-2 text-center">
                                <p class="text-xs text-[var(--sky)] font-semibold uppercase tracking-wider mb-0.5">Desc.</p>
                                <p class="mono text-sm font-bold text-[var(--sky)]">{{ $lote->tiempo_descanso_dias ?? '—' }}<span class="text-xs font-normal"> d</span></p>
                            </div>
                        </div>

                        {{-- Registrado por --}}
                        @if($lote->user)
                        <div class="flex items-center gap-2 text-xs text-[var(--text-muted)]">
                            <div class="w-5 h-5 rounded bg-[var(--green-pale)] flex items-center justify-center text-[var(--green-deep)] font-bold text-xs shrink-0">
                                {{ substr($lote->user->name, 0, 1) }}
                            </div>
                            {{ $lote->user->name }}
                        </div>
                        @endif
                    </div>
                    <form id="del-mob-{{ $lote->id }}" action="{{ route('admin.lotes.destroy', $lote) }}" method="POST" class="hidden">
                        @csrf @method('DELETE')
                    </form>
                </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            @if($lotes->hasPages())
            <div class="mt-6 fade-up d3">{{ $lotes->links() }}</div>
            @endif

            @endif
        </div>
    </div>

    {{-- ══ MODAL ELIMINAR ══ --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/50 modal-backdrop z-50 flex items-center justify-center px-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6">
            <div class="w-11 h-11 bg-[var(--rose-pale)] rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-5 h-5 text-[var(--rose)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-[var(--text-main)] text-center mb-1" style="font-family:'DM Sans',sans-serif">¿Eliminar lote?</h3>
            <p class="text-sm text-[var(--text-muted)] text-center mb-3">Estás a punto de eliminar permanentemente:</p>
            <div class="bg-[var(--rose-pale)] border border-red-200 rounded-lg px-4 py-2.5 mb-4 text-center">
                <span class="mono font-bold text-[var(--rose)] text-sm" id="loteCode"></span>
            </div>
            <p class="text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2.5 mb-5">
                ⚠️ Esta acción <strong>no se puede deshacer</strong>.
            </p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-[var(--text-main)] text-sm font-semibold py-2.5 rounded-lg transition-colors"
                        style="font-family:'DM Sans',sans-serif">
                    Cancelar
                </button>
                <button onclick="confirmDelete()"
                        class="flex-1 bg-[var(--rose)] hover:opacity-90 text-white text-sm font-semibold py-2.5 rounded-lg transition-colors shadow-sm"
                        style="font-family:'DM Sans',sans-serif">
                    Sí, eliminar
                </button>
            </div>
        </div>
    </div>

    <script>
        let deleteId = null;

        function openDeleteModal(id, codigo) {
            deleteId = id;
            document.getElementById('loteCode').textContent = codigo;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            deleteId = null;
        }

        function confirmDelete() {
            if (!deleteId) return;
            const form = document.getElementById('del-' + deleteId)
                      || document.getElementById('del-mob-' + deleteId);
            if (form) form.submit();
        }

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });
    </script>
</x-app-layout>