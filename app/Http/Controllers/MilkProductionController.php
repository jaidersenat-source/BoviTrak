<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\MilkProduction;
use Illuminate\Http\Request;

class MilkProductionController extends Controller
{
    public function index(Animal $animal)
    {
        $records = $animal->milkProductions()->with('user')->orderByDesc('date')->paginate(15);
        return view('admin.milk.index', compact('animal', 'records'));
    }

    public function create(Animal $animal)
    {
        return view('admin.milk.create', compact('animal'));
    }

    public function store(Request $request, Animal $animal)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'liters' => 'required|numeric|min:0',
            'shift' => 'nullable|string|max:20',
            'somatic_cells' => 'nullable|integer|min:0',
            'coagulos' => 'nullable|boolean',
            'mastitis' => 'nullable|boolean',
            'nipple_damage' => 'nullable|boolean',
            'nipple_damage_notes' => 'nullable|string|max:1000',
            'duct_blockage' => 'nullable|boolean',
            'treatment_dose' => 'nullable|string|max:255',
            'treatment_date' => 'nullable|date',
            'treatment_next_date' => 'nullable|date',
            'treatment_estimated_days' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        // coerciones de booleanos
        $data['mastitis'] = $request->boolean('mastitis');
        $data['coagulos'] = $request->boolean('coagulos');
        $data['nipple_damage'] = $request->boolean('nipple_damage');
        $data['duct_blockage'] = $request->boolean('duct_blockage');
        $data['user_id'] = auth()->id();

        $animal->milkProductions()->create($data);

        return redirect()->route('animals.milk.index', $animal)
                         ->with('success', 'Registro de producción agregado correctamente.');
    }

    public function show(Animal $animal, MilkProduction $milk)
    {
        return view('admin.milk.show', ['animal' => $animal, 'record' => $milk]);
    }

    public function edit(Animal $animal, MilkProduction $milk)
    {
        $record = $milk;
        return view('admin.milk.edit', compact('animal','record'));
    }

    public function update(Request $request, Animal $animal, MilkProduction $milk)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'liters' => 'required|numeric|min:0',
            'shift' => 'nullable|string|max:20',
            'somatic_cells' => 'nullable|integer|min:0',
            'coagulos' => 'nullable|boolean',
            'mastitis' => 'nullable|boolean',
            'nipple_damage' => 'nullable|boolean',
            'nipple_damage_notes' => 'nullable|string|max:1000',
            'duct_blockage' => 'nullable|boolean',
            'treatment_dose' => 'nullable|string|max:255',
            'treatment_date' => 'nullable|date',
            'treatment_next_date' => 'nullable|date',
            'treatment_estimated_days' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $data['mastitis'] = $request->boolean('mastitis');
        $data['coagulos'] = $request->boolean('coagulos');
        $data['nipple_damage'] = $request->boolean('nipple_damage');
        $data['duct_blockage'] = $request->boolean('duct_blockage');

        $milk->update($data);

        return redirect()->route('animals.milk.index', $animal)
                         ->with('success', 'Registro de producción actualizado.');
    }

    public function destroy(Animal $animal, MilkProduction $milk)
    {
        $milk->delete();
        return redirect()->route('animals.milk.index', $animal)
                         ->with('success', 'Registro de producción eliminado.');
    }
}
