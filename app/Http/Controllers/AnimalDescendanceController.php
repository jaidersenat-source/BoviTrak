<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalDescendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimalDescendanceController extends Controller
{
    /**
     * Mostrar el formulario de creación de descendencia para un animal.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\View\View
     */
    public function create(Animal $animal)
    {
        // Padres (toros) — excluir el propio animal
        $padres = Animal::where('sexo', 'macho')
            ->where('id', '!=', $animal->id)
            ->orderBy('codigo_nfc')
            ->get();

        // Madres (vacas) — excluir el propio animal
        $madres = Animal::where('sexo', 'hembra')
            ->where('id', '!=', $animal->id)
            ->orderBy('codigo_nfc')
            ->get();

        return view('admin.descendencia.create', [
            'animal' => $animal,
            'padres' => $padres,
            'madres' => $madres,
        ]);
    }

    /**
     * Guardar una nueva descendencia.
     */
    public function store(Request $request, Animal $animal)
    {
        $validated = $request->validate([
            'padre_id' => 'required|exists:animals,id',
            'madre_id' => 'required|exists:animals,id',
            'fecha_nacimiento' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);

        $errors = [];

        if ((int) $validated['padre_id'] === (int) $animal->id) {
            $errors['padre_id'] = 'El padre no puede ser el mismo animal.';
        }

        if ((int) $validated['madre_id'] === (int) $animal->id) {
            $errors['madre_id'] = 'La madre no puede ser el mismo animal.';
        }

        $padre = Animal::find($validated['padre_id']);
        $madre = Animal::find($validated['madre_id']);

        if (! $padre) {
            $errors['padre_id'] = 'Padre no encontrado.';
        } elseif ($padre->sexo !== 'macho') {
            $errors['padre_id'] = 'El registro seleccionado como padre no es un toro (sexo debe ser "macho").';
        }

        if (! $madre) {
            $errors['madre_id'] = 'Madre no encontrada.';
        } elseif ($madre->sexo !== 'hembra') {
            $errors['madre_id'] = 'El registro seleccionado como madre no es una vaca (sexo debe ser "hembra").';
        }

        if (! empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        $desc = AnimalDescendance::create([
            'animal_id' => $animal->id,
            'padre_id' => $padre->id,
            'madre_id' => $madre->id,
            'fecha_nacimiento' => $validated['fecha_nacimiento'] ?? null,
            'observaciones' => $validated['observaciones'] ?? null,
            'registrado_por' => Auth::id(),
        ]);

        return redirect()
            ->route('animals.descendencia.show', [$animal, $desc])
            ->with('success', 'Descendencia registrada correctamente');
    }

    /**
     * Mostrar la descendencia (registro específico).
     */
    public function show(Animal $animal, AnimalDescendance $record)
    {
        if ($record->animal_id !== $animal->id) {
            abort(404);
        }

        $record->load(['padre', 'madre', 'user']);

        return view('admin.descendencia.show', [
            'animal' => $animal,
            'descendencia' => $record,
        ]);
    }

    /**
     * Listado (index) de registros de descendencia del animal.
     */
    public function index(Animal $animal)
    {
        $records = $animal->descendances()->with(['padre', 'madre', 'user'])->latest()->paginate(10);

        return view('admin.descendencia.index', [
            'animal' => $animal,
            'records' => $records,
        ]);
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Animal $animal, AnimalDescendance $record)
    {
        if ($record->animal_id !== $animal->id) {
            abort(404);
        }

        $padres = Animal::where('sexo', 'macho')->where('id', '!=', $animal->id)->orderBy('codigo_nfc')->get();
        $madres = Animal::where('sexo', 'hembra')->where('id', '!=', $animal->id)->orderBy('codigo_nfc')->get();

        return view('admin.descendencia.edit', [
            'animal' => $animal,
            'record' => $record,
            'padres' => $padres,
            'madres' => $madres,
        ]);
    }

    /**
     * Actualizar registro de descendencia.
     */
    public function update(Request $request, Animal $animal, AnimalDescendance $record)
    {
        if ($record->animal_id !== $animal->id) {
            abort(404);
        }

        $validated = $request->validate([
            'padre_id' => 'required|exists:animals,id',
            'madre_id' => 'required|exists:animals,id',
            'fecha_nacimiento' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);

        $errors = [];

        if ((int) $validated['padre_id'] === (int) $animal->id) {
            $errors['padre_id'] = 'El padre no puede ser el mismo animal.';
        }
        if ((int) $validated['madre_id'] === (int) $animal->id) {
            $errors['madre_id'] = 'La madre no puede ser el mismo animal.';
        }

        $padre = Animal::find($validated['padre_id']);
        $madre = Animal::find($validated['madre_id']);

        if (! $padre) {
            $errors['padre_id'] = 'Padre no encontrado.';
        } elseif ($padre->sexo !== 'macho') {
            $errors['padre_id'] = 'El registro seleccionado como padre no es un toro (sexo debe ser "macho").';
        }

        if (! $madre) {
            $errors['madre_id'] = 'Madre no encontrada.';
        } elseif ($madre->sexo !== 'hembra') {
            $errors['madre_id'] = 'El registro seleccionado como madre no es una vaca (sexo debe ser "hembra").';
        }

        if (! empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        $record->update([
            'padre_id' => $padre->id,
            'madre_id' => $madre->id,
            'fecha_nacimiento' => $validated['fecha_nacimiento'] ?? null,
            'observaciones' => $validated['observaciones'] ?? null,
            'registrado_por' => Auth::id(),
        ]);

        return redirect()->route('animals.descendencia.show', [$animal, $record])->with('success', 'Descendencia actualizada correctamente');
    }

    /**
     * Eliminar registro de descendencia.
     */
    public function destroy(Animal $animal, AnimalDescendance $record)
    {
        if ($record->animal_id !== $animal->id) {
            abort(404);
        }

        $record->delete();

        return redirect()->route('animals.descendencia.index', $animal)->with('success', 'Registro eliminado correctamente');
    }
}
