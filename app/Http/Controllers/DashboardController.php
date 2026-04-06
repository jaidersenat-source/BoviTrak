<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\MilkProduction;
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

        // Merge alerts and milkAlerts for count/overview
        $alerts = array_merge($alerts, $milkAlerts);

        $alertsCount = count($alerts);

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

        return view('dashboard', compact(
            'totalAnimals', 'totalMales', 'totalFemales',
            'alerts', 'alertsCount',
            'milkToday', 'chartLabels', 'chartData', 'totalMilkPeriod', 'bestWeekMilk', 'avgMilk', 'topMilk'
        ));
    }
}
