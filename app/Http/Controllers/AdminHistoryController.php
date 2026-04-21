<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Lotes;
use Carbon\Carbon;

class AdminHistoryController extends Controller
{
    public function index()
    {
        $animals = Animal::with([
            'latestWeight',
            'vaccinations',
            'healthRecords',
            'reproductiveRecords',
            'cebas.registros',
            'asPadre',
            'asMadre'
        ])->get();

        // construir alertas (se delega a método reutilizable)
        $alerts = $this->buildAlerts();

        return view('admin.historial.historial', compact('animals', 'alerts'));
    }

    /**
     * Mostrar vista con todas las alertas (ganado + lotes)
     */
    public function alerts()
    {
        $alerts = $this->buildAlerts();
        return view('alerts', compact('alerts'));
    }

    /**
     * Construye el array de alertas para uso interno.
     */
    protected function buildAlerts(): array
    {
        $alerts = [];

        $watchCategories = ['carne', 'ceba', 'levante', 'doble_proposito'];
        $animalsToWatch = Animal::whereIn('proposito', $watchCategories)->get();
        foreach ($animalsToWatch as $animal) {
            $last = $animal->latestWeight()->first();
            $daysSince = $last ? Carbon::parse($last->measured_at)->diffInDays(now()) : null;
            $freq = $animal->frecuencia_peso ?? 'mensual';
            $threshold = $freq === 'quincenal' ? 15 : 30;
            if (is_null($daysSince) || $daysSince > $threshold) {
                $alerts[] = [
                    'type' => 'peso',
                    'entity' => 'animal',
                    'id' => $animal->id,
                    'label' => $animal->nombre ?? $animal->codigo_nfc,
                    'message' => 'Falta registrar peso',
                    'detail' => $last ? $last->measured_at->format('Y-m-d') : 'Nunca registrado',
                ];
            }
        }

        $cutoff = Carbon::now()->subDays(180)->toDateString();
        $animalsPendingVaccine = Animal::whereDoesntHave('vaccinations', function($q) use ($cutoff) {
            $q->whereDate('fecha_vacunacion', '>', $cutoff);
        })->get();
        foreach ($animalsPendingVaccine as $av) {
            $alerts[] = [
                'type' => 'vacunacion',
                'entity' => 'animal',
                'id' => $av->id,
                'label' => $av->nombre ?? $av->codigo_nfc,
                'message' => 'Vacunas pendientes',
                'detail' => 'Sin registro en últimos 180 días',
            ];
        }

        $healthCutoff = Carbon::now()->subDays(365)->toDateString();
        $animalsNoHealth = Animal::whereDoesntHave('healthRecords', function($q) use ($healthCutoff) {
            $q->whereDate('fecha_lavado', '>', $healthCutoff)->orWhereDate('fecha_purga', '>', $healthCutoff);
        })->get();
        foreach ($animalsNoHealth as $ah) {
            $alerts[] = [
                'type' => 'sanitario',
                'entity' => 'animal',
                'id' => $ah->id,
                'label' => $ah->nombre ?? $ah->codigo_nfc,
                'message' => 'Registro sanitario faltante',
                'detail' => 'Último registro hace > 1 año',
            ];
        }

        $lotes = Lotes::all();
        foreach ($lotes as $l) {
            if ($l->fecha_inicio_ocupacion && $l->tiempo_ocupacion_dias) {
                $days = Carbon::parse($l->fecha_inicio_ocupacion)->diffInDays(now());
                if ($days > $l->tiempo_ocupacion_dias) {
                    $alerts[] = [
                        'type' => 'lote_ocupacion',
                        'entity' => 'lote',
                        'id' => $l->id,
                        'label' => $l->codigo ?? $l->nombre_pastura ?? 'Lote '.$l->id,
                        'message' => 'Ocupación excedida',
                        'detail' => "{$days} días ocupando (plan: {$l->tiempo_ocupacion_dias}d)",
                    ];
                }
            }
            if (empty($l->fecha_roceria)) {
                $alerts[] = [
                    'type' => 'lote_roceria',
                    'entity' => 'lote',
                    'id' => $l->id,
                    'label' => $l->codigo ?? $l->nombre_pastura ?? 'Lote '.$l->id,
                    'message' => 'Rocería pendiente',
                    'detail' => 'Sin fecha de rocería registrada',
                ];
            }
        }

        return $alerts;
    }

    public function export(Request $request)
    {
        $animals = Animal::with([
            'latestWeight',
            'vaccinations',
            'healthRecords',
            'reproductiveRecords',
            'cebas.registros',
            'asPadre',
            'asMadre'
        ])->get();

        $data = compact('animals');

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.historial.historial_all_pdf', $data);
            return $pdf->download('historial-ganado.pdf');
        }

        return redirect()->back()->with('error', 'No está instalado el paquete para generar PDF. Ejecuta: composer require barryvdh/laravel-dompdf');
    }
}
