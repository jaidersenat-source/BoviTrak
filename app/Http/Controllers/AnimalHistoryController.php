<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Carbon\Carbon;

class AnimalHistoryController extends Controller
{
    public function show(Animal $animal)
    {
        $animal->load([
            'weights',
            'vaccinations',
            'healthRecords',
            'reproductiveRecords',
            'milkProductions',
            'descendances.padre',
            'descendances.madre',
            'cebas.registros',
        ]);

        // ── Alertas ──────────────────────────────────────────────────────
        $alertas = [];

        // 1. Sin peso registrado en los últimos 30 días
        $lastWeight = $animal->weights->sortByDesc('measured_at')->first();
        if (!$lastWeight) {
            $alertas[] = ['tipo' => 'danger', 'icono' => 'peso', 'mensaje' => 'No tiene ningún registro de peso.'];
        } elseif (Carbon::parse($lastWeight->measured_at)->diffInDays(now()) > 30) {
            $dias = Carbon::parse($lastWeight->measured_at)->diffInDays(now());
            $alertas[] = ['tipo' => 'warning', 'icono' => 'peso', 'mensaje' => "Último peso hace {$dias} días (más de 30)."];
        }

        // 2. Sin vacunación en los últimos 180 días (6 meses)
        $lastVac = $animal->vaccinations->sortByDesc('fecha_vacunacion')->first();
        if (!$lastVac) {
            $alertas[] = ['tipo' => 'warning', 'icono' => 'vacuna', 'mensaje' => 'No tiene vacunaciones registradas.'];
        } elseif (Carbon::parse($lastVac->fecha_vacunacion)->diffInDays(now()) > 180) {
            $meses = round(Carbon::parse($lastVac->fecha_vacunacion)->diffInDays(now()) / 30);
            $alertas[] = ['tipo' => 'warning', 'icono' => 'vacuna', 'mensaje' => "Última vacunación hace aprox. {$meses} meses."];
        }

        // 3. Sin registro sanitario en el último año
        $lastHealth = $animal->healthRecords
            ->sortByDesc(fn($h) => $h->fecha_lavado ?? $h->fecha_purga)
            ->first();
        if (!$lastHealth) {
            $alertas[] = ['tipo' => 'info', 'icono' => 'salud', 'mensaje' => 'Sin registros sanitarios (lavado/purga).'];
        }

        // 4. Hembra sin proceso reproductivo activo
        if (strtolower($animal->sexo) === 'hembra' && $animal->reproductiveRecords->isEmpty()) {
            $alertas[] = ['tipo' => 'info', 'icono' => 'reproductivo', 'mensaje' => 'No tiene procesos reproductivos registrados.'];
        }

        // 5. Animal de ceba sin sesión activa
        $propositoCeba = in_array(strtolower($animal->proposito ?? ''), ['ceba', 'carne']);
        if ($propositoCeba && $animal->cebas->isEmpty()) {
            $alertas[] = ['tipo' => 'info', 'icono' => 'ceba', 'mensaje' => 'Animal de ceba sin sesiones de seguimiento.'];
        }

        return view('admin.ganado.historial', compact('animal', 'alertas'));
    }
}
