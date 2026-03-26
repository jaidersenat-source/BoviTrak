<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalVaccination;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnimalVaccinationController extends Controller
{
    // ─── Listado de vacunaciones de un animal ─────────────────

    public function index(Animal $animal): View
    {
        $vaccinations = $animal->vaccinations()
            ->with('aplicador')
            ->orderBy('fecha_vacunacion', 'desc')
            ->paginate(10);

        return view('admin.vacunaciones.index', compact('animal', 'vaccinations'));
    }

    // ─── Formulario de creación ────────────────────────────────

    public function create(Animal $animal): View
    {
        return view('admin.vacunaciones.create', compact('animal'));
    }

    // ─── Guardar nueva vacunación ──────────────────────────────

    public function store(Request $request, Animal $animal): RedirectResponse
    {
        $validated = $request->validate([
            'vacuna'           => 'required|string|max:255',
            'dosis'            => 'required|string|max:255',
            'fecha_vacunacion' => 'required|date|before_or_equal:today',
            'lote'             => 'nullable|string|max:100',
            'nota'             => 'nullable|string|max:1000',
        ], [
            'vacuna.required'           => 'El nombre de la vacuna es obligatorio.',
            'dosis.required'            => 'La dosis es obligatoria.',
            'fecha_vacunacion.required' => 'La fecha de vacunación es obligatoria.',
            'fecha_vacunacion.before_or_equal' => 'La fecha no puede ser futura.',
        ]);

        $animal->vaccinations()->create([
            ...$validated,
            'aplicado_por' => Auth::id(),
        ]);

        return redirect()
            ->route('animals.vaccinations.index', $animal)
            ->with('success', "Vacunación registrada correctamente para " . ($animal->nombre ? $animal->nombre : $animal->codigo_nfc) . ".");
    }

    // ─── Formulario de edición ─────────────────────────────────

    public function edit(Animal $animal, AnimalVaccination $vaccination): View
    {
        // Asegurar que la vacunación pertenece al animal
        abort_if($vaccination->animal_id !== $animal->id, 404);

        return view('admin.vacunaciones.edit', compact('animal', 'vaccination'));
    }

    // ─── Actualizar vacunación ─────────────────────────────────

    public function update(Request $request, Animal $animal, AnimalVaccination $vaccination): RedirectResponse
    {
        abort_if($vaccination->animal_id !== $animal->id, 404);

        $validated = $request->validate([
            'vacuna'           => 'required|string|max:255',
            'dosis'            => 'required|string|max:255',
            'fecha_vacunacion' => 'required|date|before_or_equal:today',
            'lote'             => 'nullable|string|max:100',
            'nota'             => 'nullable|string|max:1000',
        ], [
            'vacuna.required'           => 'El nombre de la vacuna es obligatorio.',
            'dosis.required'            => 'La dosis es obligatoria.',
            'fecha_vacunacion.required' => 'La fecha de vacunación es obligatoria.',
            'fecha_vacunacion.before_or_equal' => 'La fecha no puede ser futura.',
        ]);

        $vaccination->update($validated);

        return redirect()
            ->route('animals.vaccinations.index', $animal)
            ->with('success', 'Vacunación actualizada correctamente.');
    }

    // ─── Eliminar vacunación ───────────────────────────────────

    public function destroy(Animal $animal, AnimalVaccination $vaccination): RedirectResponse
    {
        abort_if($vaccination->animal_id !== $animal->id, 404);

        $vaccination->delete();

        return redirect()
            ->route('animals.vaccinations.index', $animal)
            ->with('success', 'Vacunación eliminada correctamente.');
    }
}