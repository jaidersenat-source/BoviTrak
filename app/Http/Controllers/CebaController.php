<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Ceba;
use App\Models\CebaRegistro;
use Illuminate\Http\Request;

class CebaController extends Controller
{
    public function index(Animal $animal)
    {
        $cebas = $animal->cebas()->get();
        // mostrar sesiones de ceba para un animal
        return view('ceba.index', compact('animal', 'cebas'));
    }

    public function create(Animal $animal)
    {
        return view('ceba.create', compact('animal'));
    }

    public function store(Animal $animal, Request $request)
    {
        $data = $request->validate([
            'fecha_ingreso' => 'nullable|date',
            'peso_inicial'  => 'nullable|numeric',
            'peso_objetivo' => 'nullable|numeric',
            'destino_lote'  => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $data['animal_id'] = $animal->id;
        $ceba = Ceba::create($data);

        return redirect()->route('animals.ceba.show', [$animal, $ceba])->with('success', 'Sesión de ceba creada');
    }

    public function show(Animal $animal, Ceba $ceba)
    {
        $ceba->load('registros');

        $registros = $ceba->registros()->orderBy('medido_el')->get();

        // Calcular tendencia simple (ADG) y eficiencia de alimento
        $first = $registros->first();
        $last  = $registros->last();
        $adg = null;
        $eficiencia = null;

        if ($first && $last && $first->peso && $last->peso) {
            $days = max(1, $first->medido_el ? \Carbon\Carbon::parse($last->medido_el)->diffInDays($first->medido_el) : 1);
            $gain = $last->peso - $first->peso;
            $adg = $gain / $days; // kg por día

            $totalFeed = $registros->sum('cantidad_alimento');
            if ($totalFeed > 0) {
                $eficiencia = $gain / $totalFeed; // kg ganado por kg alimento
            }
        }

        return view('ceba.show', compact('animal', 'ceba', 'registros', 'adg', 'eficiencia'));
    }

    public function edit(Animal $animal, Ceba $ceba)
    {
        return view('ceba.edit', compact('animal', 'ceba'));
    }

    public function update(Animal $animal, Ceba $ceba, Request $request)
    {
        $data = $request->validate([
            'fecha_ingreso' => 'nullable|date',
            'peso_inicial'  => 'nullable|numeric',
            'peso_objetivo' => 'nullable|numeric',
            'destino_lote'  => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $ceba->update($data);

        return redirect()->route('animals.ceba.show', [$animal, $ceba])->with('success', 'Sesión de ceba actualizada');
    }

    public function storeRegistro(Animal $animal, Ceba $ceba, Request $request)
    {
        $data = $request->validate([
            'medido_el' => 'nullable|date',
            'peso' => 'nullable|numeric',
            'tipo_alimento' => 'nullable|string',
            'cantidad_alimento' => 'nullable|numeric',
            'observaciones' => 'nullable|string',
        ]);

        $data['medido_el'] = $data['medido_el'] ?? now();
        $data['ceba_id'] = $ceba->id;

        CebaRegistro::create($data);

        return redirect()->route('animals.ceba.show', [$animal, $ceba])->with('success', 'Registro agregado');
    }
}
