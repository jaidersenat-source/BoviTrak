<x-app-layout>
    <x-slot name="title">Panel de Control</x-slot>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

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

        body, .dash { font-family: 'DM Sans', sans-serif; background: var(--sand); color: var(--text-main); }
        .mono { font-family: 'DM Mono', monospace; }

        /* ── KPI Card ── */
        .kpi-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px 22px 18px;
            position: relative;
            overflow: hidden;
            transition: box-shadow .2s, transform .2s;
        }
        .kpi-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,.09); transform: translateY(-2px); }
        .kpi-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 3px;
        }
        .kpi-green::before  { background: linear-gradient(90deg, var(--green-deep), var(--green-light)); }
        .kpi-amber::before  { background: linear-gradient(90deg, var(--amber), #e0a050); }
        .kpi-sky::before    { background: linear-gradient(90deg, var(--sky), #4daad4); }
        .kpi-rose::before   { background: linear-gradient(90deg, var(--rose), #d47a88); }

        .kpi-icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 14px; flex-shrink: 0;
        }

        /* ── Panel card ── */
        .panel {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }
        .panel-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .panel-title { font-size: .8rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--text-muted); }
        .panel-body { padding: 20px; }

        /* ── Progress bar ── */
        .progress-track { height: 6px; background: #eee; border-radius: 99px; overflow: hidden; }
        .progress-fill  { height: 100%; border-radius: 99px; transition: width .6s ease; }

        /* ── Activity dot ── */
        .act-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-top: 6px; }

        /* ── Badge ── */
        .badge {
            display: inline-flex; align-items: center;
            padding: 2px 9px; border-radius: 99px;
            font-size: .7rem; font-weight: 600;
        }

        /* ── Sparkline container ── */
        .spark { height: 40px; }

        /* ── Stagger fade-in ── */
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(10px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .fade-up { animation: fadeUp .4s ease both; }
        .d1  { animation-delay: .05s; }
        .d2  { animation-delay: .1s;  }
        .d3  { animation-delay: .15s; }
        .d4  { animation-delay: .2s;  }
        .d5  { animation-delay: .25s; }
        .d6  { animation-delay: .3s;  }
        .d7  { animation-delay: .35s; }

        /* ── Mini table ── */
        .mini-table th { font-size: .68rem; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); font-weight: 600; padding: 0 6px 10px; }
        .mini-table td { font-size: .82rem; padding: 8px 6px; border-top: 1px solid #f0eeea; }
        .mini-table tr:first-child td { border-top: none; }

        /* ── Gauge ring ── */
        .gauge-wrap { position: relative; width: 100px; height: 100px; }
        .gauge-wrap canvas { position: absolute; top: 0; left: 0; }
        .gauge-center {
            position: absolute; inset: 0;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }

        /* responsive */
        @media (max-width: 640px) {
            .kpi-card { padding: 16px 16px 14px; }
        }

        /* Bell alert animation */
        .bell-alert { color: #a83244; }
        .bell-pulse { animation: bellPulse 1.3s infinite; }
        @keyframes bellPulse {
            0% { transform: translateY(0); }
            25% { transform: translateY(-3px) scale(1.02); }
            50% { transform: translateY(0); }
            100% { transform: translateY(0); }
        }
    </style>

    <div class="dash max-w-screen-xl mx-auto px-4 sm:px-6 py-7">

        {{-- ══ PAGE HEADER ══ --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-7 fade-up d1">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                    <span class="text-xs font-semibold text-green-600 uppercase tracking-widest">En línea</span>
                </div>
                <h1 class="text-2xl font-bold text-[var(--text-main)] tracking-tight">Panel de Control</h1>
                <p class="text-sm text-[var(--text-muted)] mt-0.5">Hato bovino · {{ now()->format('d \d\e F, Y') }}</p>
            </div>
            <div class="flex items-center gap-2">
                {{-- Botón campana de alertas --}}
                <div class="relative">
                    <button id="alertsBtn" class="relative inline-flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 {{ ($alertsCount ?? 0) > 0 ? 'bell-pulse' : '' }}" title="Alertas">
                        <span class="sr-only">Alertas</span>
                        <svg class="w-5 h-5 {{ ($alertsCount ?? 0) > 0 ? 'bell-alert' : 'text-[var(--rose)]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1"/></svg>
                        @if(($alertsCount ?? 0) > 0)
                        <span class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center px-1.5 py-0.5 text-xs rounded-full" style="background:#fff;color:var(--rose);border:1px solid var(--rose);font-weight:700">{{ $alertsCount }}</span>
                        @endif
                    </button>
                    <div id="alertsDropdown" class="hidden z-50 origin-top-right absolute right-0 mt-2 w-96 bg-white border border-[var(--border)] rounded-lg shadow-lg">
                        <div class="p-3 text-sm font-semibold border-b">Alertas pendientes ({{ $alertsCount ?? 0 }})</div>
                        <div class="max-h-72 overflow-auto">
                            @forelse($alerts ?? [] as $a)
                            <a href="{{ isset($a['type']) && $a['type'] === 'milk' ? route('animals.milk.index', $a['animal_id']) : route('animals.weights.index', $a['animal_id']) }}" class="block px-3 py-2 hover:bg-gray-50 border-b last:border-b-0">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold">{{ $a['name'] }}</p>
                                        <p class="text-xs text-[var(--text-muted)]">{{ $a['issue'] ?? ucfirst($a['proposito'] ?? '') }} · {{ $a['last_date'] ?? ($a['date'] ?? '—') }}</p>
                                    </div>
                                    <div class="text-right text-xs text-[var(--text-muted)]">
                                        {{ isset($a['type']) && $a['type'] === 'milk' ? 'Leche' : 'Peso' }}
                                    </div>
                                </div>
                            </a>
                            @empty
                            <div class="p-3 text-sm text-[var(--text-muted)]">No hay alertas pendientes.</div>
                            @endforelse
                        </div>
                        <div class="p-2 border-t text-center">
                            <a href="/alerts" class="text-xs text-[var(--green-mid)] hover:underline">Ver todas las alertas</a>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.ganado.index') }}"
                   class="text-sm font-semibold text-[var(--green-mid)] border border-[var(--green-mid)] px-4 py-2 rounded-lg hover:bg-[var(--green-pale)] transition-colors">
                    Ver Ganado
                </a>
                <a href="{{ route('admin.ganado.create') }}"
                   class="text-sm font-semibold text-white bg-[var(--green-mid)] hover:bg-[var(--green-deep)] px-4 py-2 rounded-lg transition-colors shadow-sm flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                    </svg>
                    Nuevo Animal
                </a>
            </div>
        </div>

        

        {{-- ══ KPI ROW ══ --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

            {{-- Total animales --}}
            <div class="kpi-card kpi-green fade-up d1 col-span-2 sm:col-span-1">
                <div class="kpi-icon bg-[var(--green-pale)]">
                    <svg class="w-5 h-5 text-[var(--green-deep)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-xs font-semibold text-[var(--text-muted)] mb-1">Total Animales</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-[var(--text-main)]">{{ $totalAnimals ?? 0 }}</span>
                    @if(isset($animalsGrowthPct) && $animalsGrowthPct > 0)
                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-1.5 py-0.5 rounded-full">+{{ $animalsGrowthPct }}%</span>
                    @endif
                </div>
                <p class="text-xs text-[var(--text-muted)] mt-2">{{ $totalMales ?? 0 }} machos · {{ $totalFemales ?? 0 }} hembras</p>
            </div>

            {{-- Producción --}}
            <div class="kpi-card kpi-sky fade-up d2">
                <div class="kpi-icon bg-[var(--sky-pale)]">
                    <svg class="w-5 h-5 text-[var(--sky)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2s5 5.5 5 9a5 5 0 11-10 0c0-3.5 5-9 5-9z"/>
                    </svg>
                </div>
                <p class="text-xs font-semibold text-[var(--text-muted)] mb-1">Producción Hoy</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-[var(--text-main)]">{{ $milkToday ?? '—' }}</span>
                    <span class="text-sm text-[var(--text-muted)]">L</span>
                </div>
                <p class="text-xs text-[var(--text-muted)] mt-2">Promedio sem.: {{ $avgMilk ?? '—' }} L/día</p>
            </div>

            {{-- Vacunaciones --}}
            <div class="kpi-card kpi-amber fade-up d3">
                <div class="kpi-icon bg-[var(--amber-pale)]">
                    <svg class="w-5 h-5 text-[var(--amber)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <p class="text-xs font-semibold text-[var(--text-muted)] mb-1">Vacunaciones</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-[var(--text-main)]">{{ $vaccinationsThisMonth ?? '—' }}</span>
                </div>
                <p class="text-xs text-[var(--text-muted)] mt-2">Este mes · {{ $pendingVaccinations ?? 0 }} pendientes</p>
            </div>

            {{-- Alertas (tarjeta pequeña) --}}
            <div class="kpi-card kpi-rose fade-up d4">
                <div class="kpi-icon bg-[var(--rose-pale)]">
                    <svg class="w-5 h-5 text-[var(--rose)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1"/>
                    </svg>
                </div>
                <p class="text-xs font-semibold text-[var(--text-muted)] mb-1">Alertas</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-[var(--text-main)]">{{ $alertsCount ?? 0 }}</span>
                </div>
                <p class="text-xs text-[var(--text-muted)] mt-2">Pendientes · <a href="#" onclick="document.getElementById('alertsBtn')?.click(); return false;" class="text-[var(--green-mid)] hover:underline">Ver campana</a></p>
            </div>

            
        </div>

        {{-- ══ FILA CENTRAL: Gráfico principal + Composición + Accesos ══ --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-4">

          {{-- Gráfico producción leche --}}
<div class="panel lg:col-span-7 fade-up d3">
    <div class="panel-header">
        <span class="panel-title">Producción de Leche</span>
        <div class="flex items-center gap-2">
            <span class="badge bg-[var(--sky-pale)] text-[var(--sky)]">Últimas 8 semanas</span>
        </div>
    </div>
    <div class="panel-body">
        <div class="flex items-center gap-6 mb-4">
            <div>
                <p class="text-xs text-[var(--text-muted)]">Total período</p>
                <p class="text-xl font-bold text-[var(--text-main)]">
                    {{ isset($totalMilkPeriod) ? number_format($totalMilkPeriod, 0, ',', '.') : '—' }}
                    <span class="text-sm font-normal text-[var(--text-muted)]">L</span>
                </p>
            </div>
            <div class="w-px h-8 bg-[var(--border)]"></div>
            <div>
                <p class="text-xs text-[var(--text-muted)]">Mejor semana</p>
                <p class="text-xl font-bold text-[var(--sky)]">
                    {{ isset($bestWeekMilk) ? number_format($bestWeekMilk, 0, ',', '.') : '—' }}
                    <span class="text-sm font-normal text-[var(--text-muted)]">L</span>
                </p>
            </div>
            <div class="w-px h-8 bg-[var(--border)]"></div>
            <div>
                <p class="text-xs text-[var(--text-muted)]">Promedio/día</p>
                <p class="text-xl font-bold text-[var(--text-main)]">
                    {{ isset($avgMilk) ? number_format($avgMilk, 2, ',', '.') : '—' }}
                    <span class="text-sm font-normal text-[var(--text-muted)]">L</span>
                </p>
            </div>
        </div>
 
        <div class="mb-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-[var(--text-muted)]">Producción hoy</p>
                    <p class="text-3xl font-bold text-[var(--text-main)]">
                        {{ isset($milkToday) ? number_format($milkToday, 2, ',', '.') : '0' }}
                        <span class="text-sm font-normal text-[var(--text-muted)]">L</span>
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-[var(--text-muted)]">Periodo mostrado</p>
                    <p class="text-sm font-semibold text-[var(--text-muted)]">Últimas 8 semanas</p>
                </div>
            </div>
        </div>
 
        {{-- Contenedor del canvas --}}
        <div style="position:relative; width:100%; height:220px;">
            <canvas id="chartMilk"></canvas>
        </div>
    </div>
</div>
            {{-- Composición del hato --}}
            <div class="panel lg:col-span-5 fade-up d4">
                <div class="panel-header">
                    <span class="panel-title">Composición del Hato</span>
                </div>
                <div class="panel-body">
                    {{-- Gauge --}}
                    <div class="flex items-center justify-center mb-5">
                        <div class="gauge-wrap">
                            <canvas id="chartGauge" width="100" height="100"></canvas>
                            <div class="gauge-center">
                                <span class="text-xl font-bold text-[var(--text-main)]">{{ $femalePct ?? 0 }}%</span>
                                <span class="text-xs text-[var(--text-muted)]">hembras</span>
                            </div>
                        </div>
                    </div>

                    {{-- Barras por categoría --}}
                    <div class="space-y-3">
                        @php
                            $categories = $herdCategories ?? [
                                ['label' => 'Vacas en ordeño', 'count' => $milkingCows ?? 0,    'pct' => $milkingPct ?? 0,    'color' => '#1d6fa4'],
                                ['label' => 'Hembras gestantes', 'count' => $pregnantCows ?? 0, 'pct' => $pregnantPct ?? 0,  'color' => '#c07d2a'],
                                ['label' => 'Novillas',          'count' => $heifers ?? 0,       'pct' => $heifersPct ?? 0,   'color' => '#8fa060'],
                                ['label' => 'Machos',            'count' => $totalMales ?? 0,    'pct' => $malePct ?? 0,      'color' => '#6b7280'],
                            ];
                        @endphp
                        @foreach($categories as $cat)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs font-medium text-[var(--text-main)]">{{ $cat['label'] }}</span>
                                <div class="flex items-center gap-2">
                                    <span class="mono text-xs text-[var(--text-muted)]">{{ $cat['count'] }}</span>
                                    <span class="text-xs font-semibold text-[var(--text-muted)]">{{ $cat['pct'] }}%</span>
                                </div>
                            </div>
                            <div class="progress-track">
                                <div class="progress-fill" style="width: {{ $cat['pct'] }}%; background: {{ $cat['color'] }};"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ FILA INFERIOR ══ --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">

            {{-- Top producción --}}
            <div class="panel lg:col-span-4 fade-up d5">
                <div class="panel-header">
                    <span class="panel-title">Top Productoras</span>
                    <span class="badge bg-[var(--sky-pale)] text-[var(--sky)]">Este mes</span>
                </div>
                <div class="panel-body !p-0">
                    <table class="w-full mini-table">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="pl-5 text-left py-3">#</th>
                                <th class="text-left">Animal</th>
                                <th class="text-left">Raza</th>
                                <th class="pr-5 text-right">L / día</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topMilk ?? [] as $i => $m)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="pl-5">
                                    @if($i === 0)
                                        <span class="text-amber-500 font-bold mono text-xs">01</span>
                                    @else
                                        <span class="mono text-xs text-[var(--text-muted)]">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</span>
                                    @endif
                                </td>
                                <td class="font-semibold text-[var(--text-main)]">{{ $m['name'] ?? $m['nfc'] ?? '—' }}</td>
                                <td class="text-[var(--text-muted)]">{{ $m['raza'] ?? '—' }}</td>
                                <td class="pr-5 text-right font-bold text-[var(--sky)]">{{ $m['liters'] ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="pl-5 py-6 text-sm text-[var(--text-muted)]">Sin datos registrados</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tendencia de peso --}}
            <div class="panel lg:col-span-4 fade-up d6">
                <div class="panel-header">
                    <span class="panel-title">Tendencia de Peso</span>
                    <span class="badge bg-[var(--green-pale)] text-[var(--green-deep)]">Promedio Hato</span>
                </div>
                <div class="panel-body">
                    <div class="flex items-baseline gap-2 mb-4">
                        <span class="text-2xl font-bold text-[var(--text-main)]">{{ $avgWeight ?? '—' }}</span>
                        <span class="text-sm text-[var(--text-muted)]">kg promedio</span>
                        @if(isset($weightGrowthPct))
                        <span class="text-xs font-semibold {{ $weightGrowthPct >= 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} px-1.5 py-0.5 rounded-full ml-auto">
                            {{ $weightGrowthPct >= 0 ? '+' : '' }}{{ $weightGrowthPct }}%
                        </span>
                        @endif
                    </div>
                    <div style="height:140px; position:relative;">
                        <canvas id="chartWeight"></canvas>
                    </div>
                </div>
            </div>

            {{-- Actividad reciente --}}
            <div class="panel lg:col-span-4 fade-up d7">
                <div class="panel-header">
                    <span class="panel-title">Actividad Reciente</span>
                </div>
                <div class="panel-body space-y-4">
                    @php
                    $dotColors = [
                        'peso'        => '#1d6fa4',
                        'leche'       => '#0e8a6e',
                        'vacunacion'  => '#c07d2a',
                        'sanitario'   => '#5a6e38',
                        'reproductivo'=> '#a83244',
                        'default'     => '#9ca3af',
                    ];
                    @endphp
                    @forelse($recentActivities ?? [] as $act)
                    <div class="flex items-start gap-3">
                        <div class="act-dot mt-1.5" style="background: {{ $dotColors[$act['type'] ?? 'default'] ?? $dotColors['default'] }};"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-[var(--text-main)] truncate">{{ $act['title'] ?? 'Evento' }}</p>
                            <p class="text-xs text-[var(--text-muted)]">{{ $act['meta'] ?? '' }}</p>
                        </div>
                        <span class="text-xs text-[var(--text-muted)] shrink-0 mt-0.5">{{ $act['time'] ?? '' }}</span>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <svg class="w-8 h-8 text-gray-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-[var(--text-muted)]">Sin actividad reciente</p>
                    </div>
                    @endforelse
                </div>

                {{-- Accesos rápidos --}}
                <div class="border-t border-[var(--border)] px-5 py-4">
                    <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-3">Acceso rápido</p>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('admin.ganado.index') }}" class="flex items-center gap-2 text-xs font-semibold text-[var(--green-deep)] bg-[var(--green-pale)] hover:bg-green-100 px-3 py-2 rounded-lg transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            Ganado
                        </a>
                        <a href="{{ route('admin.lotes.index') }}" class="flex items-center gap-2 text-xs font-semibold text-[var(--amber)] bg-[var(--amber-pale)] hover:bg-amber-100 px-3 py-2 rounded-lg transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Lotes
                        </a>
                        @if(Route::has('vaccinations.index'))
                        <a href="{{ route('vaccinations.index') }}" class="flex items-center gap-2 text-xs font-semibold text-[var(--sky)] bg-[var(--sky-pale)] hover:bg-sky-100 px-3 py-2 rounded-lg transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            Vacunas
                        </a>
                        @endif
                        <a href="{{ route('admin.ganado.create') }}" class="flex items-center gap-2 text-xs font-semibold text-white bg-[var(--green-mid)] hover:bg-[var(--green-deep)] px-3 py-2 rounded-lg transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/></svg>
                            Nuevo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
(function() {

    Chart.defaults.font.family = "'DM Sans', sans-serif";
    Chart.defaults.color = '#7a7d72';

    // ── Helpers ────────────────────────────────────────────────────────────
    function norm(v) {
        if (v === null || v === undefined || v === '') return 0;
        const n = parseFloat(String(v).replace(',', '.'));
        return isNaN(n) ? 0 : n;
    }

    function showEmpty(canvas, msg) {
        canvas.style.display = 'none';
        const el = document.createElement('div');
        el.style.cssText = 'text-align:center;font-size:13px;padding:3rem 0;opacity:.5;color:inherit';
        el.innerText = msg ?? 'Sin datos disponibles';
        canvas.parentElement.appendChild(el);
    }

    // ── Milk line chart ────────────────────────────────────────────────────
    const milkCtx = document.getElementById('chartMilk');
    if (milkCtx) {
        const labels   = {!! json_encode($chartLabels ?? ['Sem 1','Sem 2','Sem 3','Sem 4','Sem 5','Sem 6','Sem 7','Sem 8']) !!};
        const rawData  = {!! json_encode($chartData   ?? [112, 138, 125, 156, 163, 149, 171, 168]) !!};
        const data     = rawData.map(norm);
        const total    = data.reduce((s, v) => s + v, 0);

        if (total === 0) {
            showEmpty(milkCtx, 'Sin datos de producción en el periodo seleccionado');
        } else {
            const suggestedMax = Math.ceil((Math.max(...data) + 10) / 10) * 10;
            new Chart(milkCtx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        data,
                        borderColor: '#1d6fa4',
                        backgroundColor: 'rgba(29,111,164,0.08)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#1d6fa4',
                        pointBorderWidth: 0,
                        borderWidth: 2.5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e2318',
                            titleFont: { weight: '500', size: 12 },
                            bodyFont: { size: 12 },
                            padding: 10,
                            cornerRadius: 6,
                            callbacks: { label: ctx => '  ' + ctx.parsed.y.toFixed(2) + ' L' }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: {
                                color: '#7a7d72',
                                maxRotation: 0,
                                autoSkip: true,
                                maxTicksLimit: 8
                            }
                        },
                        y: {
                            beginAtZero: true,
                            suggestedMax,
                            grid: { color: '#f0eeea', borderDash: [4, 4] },
                            border: { display: false },
                            ticks: {
                                color: '#7a7d72',
                                callback: v => v + ' L'
                            }
                        }
                    }
                }
            });
        }
    }

    // ── Weight bar chart ───────────────────────────────────────────────────
    const wCtx = document.getElementById('chartWeight');
    if (wCtx) {
        const wLabels = {!! json_encode($weightLabels ?? ['Ene','Feb','Mar','Abr','May','Jun']) !!};
        const wRaw    = {!! json_encode($weightData   ?? [380, 385, 390, 388, 395, 400]) !!};
        const wData   = wRaw.map(norm);

        if (wData.reduce((s, v) => s + v, 0) === 0) {
            showEmpty(wCtx, 'Sin datos de peso en el periodo');
        } else {
            const wMin = Math.max(0, Math.min(...wData) - 20);
            const wMax = Math.ceil((Math.max(...wData) + 15) / 10) * 10;

            new Chart(wCtx, {
                type: 'bar',
                data: {
                    labels: wLabels,
                    datasets: [{
                        data: wData,
                        backgroundColor: '#eef3e6',
                        hoverBackgroundColor: '#5a6e38',
                        borderRadius: 5,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e2318',
                            padding: 10,
                            cornerRadius: 8,
                            callbacks: { label: ctx => '  ' + ctx.parsed.y.toFixed(1) + ' kg' }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { maxRotation: 0 }
                        },
                        y: {
                            min: wMin,
                            max: wMax,
                            grid: { color: '#f0eeea' },
                            border: { display: false },
                            ticks: { callback: v => v + ' kg' }
                        }
                    }
                }
            });
        }
    }

    // ── Alerts dropdown toggle ─────────────────────────────────────────────
    const alertsBtn = document.getElementById('alertsBtn');
    const alertsDropdown = document.getElementById('alertsDropdown');
    if (alertsBtn && alertsDropdown) {
        let movedToBody = false;
        alertsBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const isHidden = alertsDropdown.classList.contains('hidden');
            if (isHidden) {
                // move dropdown to body and position fixed so it overlays everything
                if (!movedToBody) {
                    document.body.appendChild(alertsDropdown);
                    movedToBody = true;
                }
                alertsDropdown.style.position = 'fixed';
                alertsDropdown.style.zIndex = 9999;
                // compute position near the button
                const rect = alertsBtn.getBoundingClientRect();
                const ddWidth = alertsDropdown.offsetWidth || 360;
                let left = rect.right - ddWidth;
                if (left < 8) left = 8;
                const top = rect.bottom + 8;
                alertsDropdown.style.left = left + 'px';
                alertsDropdown.style.top = top + 'px';
                alertsDropdown.classList.remove('hidden');
            } else {
                alertsDropdown.classList.add('hidden');
            }
        });
        // cerrar al click fuera
        document.addEventListener('click', function () {
            if (!alertsDropdown.classList.contains('hidden')) alertsDropdown.classList.add('hidden');
        });
        // evitar cerrar al click dentro del dropdown
        alertsDropdown.addEventListener('click', function (e) { e.stopPropagation(); });
    }

    // ── Doughnut gauge ─────────────────────────────────────────────────────
    const gCtx = document.getElementById('chartGauge');
    if (gCtx) {
        const femalePct = {{ $femalePct ?? 60 }};
        const pct = Math.min(100, Math.max(0, femalePct));
        new Chart(gCtx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [pct, 100 - pct],
                    backgroundColor: ['#5a6e38', '#eef3e6'],
                    borderWidth: 0,
                    hoverOffset: 0,
                }]
            },
            options: {
                cutout: '72%',
                responsive: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                },
                animation: { animateRotate: true, duration: 900 }
            }
        });
    }

})();
</script>

</x-app-layout>