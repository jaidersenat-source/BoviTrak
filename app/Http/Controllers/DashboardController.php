<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\MilkProduction;
use App\Models\AnimalVaccination;
use App\Models\AnimalWeight;
use App\Models\AnimalHealthRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Mostrar panel de control con alertas de pesaje.
     */
    public function index(Request $request)
    {
        // métricas básicas
        $totalAnimals = Animal::count();
        $totalMales   = Animal::where('sexo', 'macho')->count();
        $totalFemales = Animal::where('sexo', 'hembra')->count();

        // categorías a revisar para pesajes obligatorios
        $watchCategories = ['carne', 'ceba', 'levante', 'doble_proposito'];

        $alerts = [];

        $animals = Animal::whereIn('proposito', $watchCategories)->get();

        foreach ($animals as $animal) {
            $last = $animal->latestWeight()->first();
            $daysSince = $last ? Carbon::parse($last->measured_at)->diffInDays(now()) : null;

            $freq = $animal->frecuencia_peso ?? 'mensual';
            $threshold = $freq === 'quincenal' ? 15 : 30;

            if (is_null($daysSince) || $daysSince > $threshold) {
                $alerts[] = [
                    'animal_id' => $animal->id,
                    'name'      => $animal->nombre ?? $animal->codigo_nfc,
                    'proposito' => $animal->proposito,
                    'last_date' => $last ? $last->measured_at->format('Y-m-d') : null,
                    'days'      => $daysSince,
                    'threshold' => $threshold,
                    'freq'      => $freq,
                ];
            }
        }

        // Revisar registros de leche recientes para calidad (mastitis / coágulos)
        $milkAlerts = [];
        $animalsWithMilk = Animal::with(['milkProductions' => function($q){ $q->orderByDesc('date')->limit(1); }])->get();
        foreach ($animalsWithMilk as $animal) {
            $lastMilk = $animal->milkProductions->first();
            if ($lastMilk) {
                // generar alerta si hay mastitis, coágulos, taponamiento de conductos o daño en pezones
                if ($lastMilk->mastitis || $lastMilk->coagulos || $lastMilk->duct_blockage || $lastMilk->nipple_damage) {
                    $issue = $lastMilk->mastitis ? 'Mastitis' : ($lastMilk->coagulos ? 'Coágulos' : ($lastMilk->duct_blockage ? 'Taponamiento conductos' : 'Daño en pezones'));
                    $milkAlerts[] = [
                        'animal_id' => $animal->id,
                        'name' => $animal->nombre ?? $animal->codigo_nfc,
                        'proposito' => $animal->proposito ?? null,
                        'issue' => $issue,
                        'date' => $lastMilk->date ? $lastMilk->date->format('Y-m-d') : null,
                        'last_date' => $lastMilk->date ? $lastMilk->date->format('Y-m-d') : null,
                        'days' => null,
                        'threshold' => null,
                        'freq' => $animal->frecuencia_peso ?? null,
                        'type' => 'milk',
                    ];
                }
            }
        }

        // Merge alerts and milkAlerts for overview
        $alerts = array_merge($alerts, $milkAlerts);

        // --- Estadísticas de leche: hoy y últimas 8 semanas ---
        $today = Carbon::today();
        $milkToday = (float) MilkProduction::whereDate('date', $today)->sum('liters');

        // últimas 8 semanas (semana actual + 7 previas), por semana
        $weeks = [];
        $chartLabels = [];
        $chartData = [];
        // queremos 8 semanas, desde 7 semanas atrás hasta la actual
        for ($i = 7; $i >= 0; $i--) {
            $start = Carbon::now()->startOfWeek()->subWeeks($i)->startOfDay();
            $end   = (clone $start)->endOfWeek()->endOfDay();
            $sum = (float) MilkProduction::whereBetween('date', [$start->toDateString(), $end->toDateString()])->sum('liters');
            $chartLabels[] = $start->format('d M') . ' - ' . $end->format('d M');
            $chartData[] = $sum;
            $weeks[] = ['start' => $start, 'end' => $end, 'sum' => $sum];
        }

        $totalMilkPeriod = array_sum($chartData);
        $bestWeekMilk = count($chartData) ? max($chartData) : 0;
        $avgMilk = $totalMilkPeriod > 0 ? round($totalMilkPeriod / (8 * 7), 2) : 0; // L por día promedio en el periodo (8 semanas)

        // Vacunaciones: este mes y pendientes (sin vacuna en últimos 180 días)
        $startMonth = Carbon::now()->startOfMonth()->toDateString();
        $endMonth = Carbon::now()->toDateString();
        $vaccinationsThisMonth = (int) AnimalVaccination::whereBetween('fecha_vacunacion', [$startMonth, $endMonth])->count();

        $cutoff = Carbon::now()->subDays(180)->toDateString();
        // Animales que NO tienen ninguna vacunación posterior al cutoff (es decir: sin vacuna en últimos 180 días)
        $pendingVaccinations = Animal::whereDoesntHave('vaccinations', function($q) use ($cutoff) {
            $q->whereDate('fecha_vacunacion', '>', $cutoff);
        })->count();

        // Añadir alertas individuales para animales sin vacuna reciente
        $animalsPendingVaccine = Animal::whereDoesntHave('vaccinations', function($q) use ($cutoff) {
            $q->whereDate('fecha_vacunacion', '>', $cutoff);
        })->get();
        foreach ($animalsPendingVaccine as $av) {
            $alerts[] = [
                'animal_id' => $av->id,
                'name' => $av->nombre ?? $av->codigo_nfc,
                'proposito' => $av->proposito ?? null,
                'last_date' => null,
                'days' => null,
                'threshold' => null,
                'freq' => null,
                'type' => 'vacunacion',
                'issue' => 'Vacunas pendientes (sin registro recientes)'
            ];
        }

        // Alerta: animales sin registro sanitario (lavado/purga) en 365 días
        $healthCutoff = Carbon::now()->subDays(365)->toDateString();
        $animalsNoHealth = Animal::whereDoesntHave('healthRecords', function($q) use ($healthCutoff) {
            $q->whereDate('fecha_lavado', '>', $healthCutoff)->orWhereDate('fecha_purga', '>', $healthCutoff);
        })->get();
        foreach ($animalsNoHealth as $ah) {
            $alerts[] = [
                'animal_id' => $ah->id,
                'name' => $ah->nombre ?? $ah->codigo_nfc,
                'proposito' => $ah->proposito ?? null,
                'last_date' => null,
                'days' => null,
                'threshold' => null,
                'freq' => null,
                'type' => 'sanitario',
                'issue' => 'Registro sanitario faltante (último > 1 año)'
            ];
        }

        // Recalcular conteo de alertas después de añadir vacunas/sanitarios
        $alertsCount = count($alerts);

        // Top productoras este mes (promedio L/día en el mes hasta hoy)
        $startMonth = Carbon::now()->startOfMonth()->toDateString();
        $endMonth = Carbon::now()->toDateString();
        $daysThisMonth = Carbon::now()->day;
        $topMilkQuery = MilkProduction::select('animal_id', DB::raw('SUM(liters) as total_liters'))
            ->whereBetween('date', [$startMonth, $endMonth])
            ->groupBy('animal_id')
            ->orderByDesc('total_liters')
            ->limit(5)
            ->get();

        $topMilk = [];
        foreach ($topMilkQuery as $row) {
            $animal = Animal::find($row->animal_id);
            $avgPerDay = $daysThisMonth ? round($row->total_liters / $daysThisMonth, 2) : round($row->total_liters, 2);
            $topMilk[] = [
                'name' => $animal->nombre ?? $animal->codigo_nfc ?? '—',
                'raza' => $animal->raza ?? '—',
                'liters' => $avgPerDay,
            ];
        }

        // Composición del hato
        $femalePct = $totalAnimals ? round(($totalFemales / $totalAnimals) * 100) : 0;

        $milkingCows = Animal::whereIn('proposito', ['leche', 'doble_proposito'])->where('sexo', 'hembra')->count();
        $milkingPct = $totalAnimals ? round(($milkingCows / $totalAnimals) * 100) : 0;

        $pregnantCows = Animal::whereHas('reproductiveRecords', function($q){ $q->whereNotNull('fecha_prenez'); })->count();
        $pregnantPct = $totalAnimals ? round(($pregnantCows / $totalAnimals) * 100) : 0;

        $heifers = Animal::where('proposito', 'levante')->count();
        $heifersPct = $totalAnimals ? round(($heifers / $totalAnimals) * 100) : 0;

        $malePct = $totalAnimals ? round(($totalMales / $totalAnimals) * 100) : 0;

        // --- Tendencia de peso: promedio del hato y últimos 6 meses ---
        $avgWeight = 0;
        $animalsWithLatest = Animal::with('latestWeight')->get();
        $sumW = 0; $cntW = 0;
        foreach ($animalsWithLatest as $a) {
            if ($a->latestWeight) {
                $sumW += (float) $a->latestWeight->peso;
                $cntW++;
            }
        }
        $avgWeight = $cntW ? round($sumW / $cntW, 1) : 0;

        $weightLabels = [];
        $weightData = [];
        for ($i = 5; $i >= 0; $i--) {
            $start = Carbon::now()->startOfMonth()->subMonths($i)->startOfDay();
            $end = (clone $start)->endOfMonth()->endOfDay();
            $label = $start->format('M');
            $avg = (float) AnimalWeight::whereBetween('measured_at', [$start->toDateString(), $end->toDateString()])->avg('peso');
            $weightLabels[] = $label;
            $weightData[] = $avg ? round($avg, 1) : 0;
        }

        // % de variación entre último mes y anterior
        $weightGrowthPct = 0;
        $n = count($weightData);
        if ($n >= 2) {
            $last = $weightData[$n - 1];
            $prev = $weightData[$n - 2];
            if ($prev != 0) {
                $weightGrowthPct = (int) round((($last - $prev) / $prev) * 100);
            }
        }

        // --- Actividad reciente: últimos eventos (peso, leche, vacunas, sanitarios) ---
        $recent = [];

        $weights = \App\Models\AnimalWeight::with('animal')->orderByDesc('measured_at')->limit(6)->get();
        foreach ($weights as $w) {
            $recent[] = [
                'type' => 'peso',
                'title' => 'Peso registrado · ' . ($w->animal->nombre ?? $w->animal->codigo_nfc ?? '—'),
                'meta' => ($w->peso ? number_format($w->peso,1,',','.') . ' kg' : '—'),
                'time' => $w->measured_at ? $w->measured_at->diffForHumans() : '',
                'ts' => $w->measured_at,
            ];
        }

        $milks = MilkProduction::with('animal')->orderByDesc('date')->limit(6)->get();
        foreach ($milks as $m) {
            $recent[] = [
                'type' => 'leche',
                'title' => 'Registro de leche · ' . ($m->animal->nombre ?? $m->animal->codigo_nfc ?? '—'),
                'meta' => ($m->liters ? number_format($m->liters,2,',','.') . ' L' : '—'),
                'time' => $m->date ? $m->date->diffForHumans() : '',
                'ts' => $m->date,
            ];
        }

        $vacs = AnimalVaccination::with('animal')->orderByDesc('fecha_vacunacion')->limit(6)->get();
        foreach ($vacs as $v) {
            $recent[] = [
                'type' => 'vacunacion',
                'title' => 'Vacunación · ' . ($v->animal->nombre ?? $v->animal->codigo_nfc ?? '—'),
                'meta' => ($v->vacuna ? $v->vacuna : 'Vacuna') . ' · ' . ($v->dosis ?? ''),
                'time' => $v->fecha_vacunacion ? $v->fecha_vacunacion->diffForHumans() : '',
                'ts' => $v->fecha_vacunacion,
            ];
        }

        $healths = AnimalHealthRecord::with('animal')->orderByDesc('fecha_lavado')->limit(6)->get();
        foreach ($healths as $h) {
            $date = $h->fecha_lavado ?? $h->fecha_purga ?? null;
            $recent[] = [
                'type' => 'sanitario',
                'title' => ($h->fecha_lavado ? 'Lavado' : ($h->fecha_purga ? 'Purga' : 'Registro sanitario')) . ' · ' . ($h->animal->nombre ?? $h->animal->codigo_nfc ?? '—'),
                'meta' => $h->observaciones ? (strlen($h->observaciones) > 60 ? substr($h->observaciones,0,57) . '...' : $h->observaciones) : ($h->tipo ?? ''),
                'time' => $date ? $date->diffForHumans() : '',
                'ts' => $date,
            ];
        }

        // ordenar por timestamp y limitar a 8
        usort($recent, function($a, $b) {
            $ta = 0; $tb = 0;
            if (!empty($a['ts'])) {
                if (is_object($a['ts']) && method_exists($a['ts'], 'getTimestamp')) $ta = $a['ts']->getTimestamp();
                else $ta = strtotime($a['ts']);
            }
            if (!empty($b['ts'])) {
                if (is_object($b['ts']) && method_exists($b['ts'], 'getTimestamp')) $tb = $b['ts']->getTimestamp();
                else $tb = strtotime($b['ts']);
            }
            return $tb <=> $ta;
        });
        $recentActivities = array_slice($recent, 0, 4);

        return view('dashboard', compact(
            'totalAnimals', 'totalMales', 'totalFemales',
            'alerts', 'alertsCount',
            'milkToday', 'chartLabels', 'chartData', 'totalMilkPeriod', 'bestWeekMilk', 'avgMilk', 'topMilk',
            'vaccinationsThisMonth', 'pendingVaccinations',
            'femalePct',
            'milkingCows', 'milkingPct',
            'pregnantCows', 'pregnantPct',
            'heifers', 'heifersPct',
            'malePct',
            'avgWeight', 'weightLabels', 'weightData', 'weightGrowthPct',
            'recentActivities'
        ));
    }
}
