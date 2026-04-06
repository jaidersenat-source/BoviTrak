<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalHealthRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnimalHealthRecordController extends Controller
{
    // ─── Listado ───────────────────────────────────────────────

    public function index(Animal $animal): View
    {
        $records = $animal->healthRecords()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.sanitario.index', compact('animal', 'records'));
    }

    // ─── Formulario de creación ────────────────────────────────

    public function create(Animal $animal): View
    {
        return view('admin.sanitario.create', compact('animal'));
    }

    /**
     * Mostrar formulario para registrar un lavado en lote (varios animales).
     */
    public function createBatch(): View
    {
        $animals = Animal::orderBy('codigo_nfc')->get();
        return view('admin.sanitario.create_batch', compact('animals'));
    }

    // ─── Guardar ───────────────────────────────────────────────

    public function store(Request $request, Animal $animal): RedirectResponse
    {
        $validated = $request->validate([
            // Sección 1: Lavado
            'fecha_lavado'    => 'nullable|date|before_or_equal:today',
            'producto_lavado' => 'nullable|string|max:255|required_with:fecha_lavado',
            'producto_lavado_secundario' => 'nullable|string|max:255',
            // Sección 2: Purga
            'fecha_purga'     => 'nullable|date|before_or_equal:today',
            'tipo_purgante'   => 'nullable|string|max:255|required_with:fecha_purga',
            // General
            'observaciones'   => 'nullable|string|max:1000',
        ], [
            'fecha_lavado.before_or_equal'    => 'La fecha de lavado no puede ser futura.',
            'fecha_purga.before_or_equal'     => 'La fecha de purga no puede ser futura.',
            'producto_lavado.required_with'   => 'Ingresa el producto si registras una fecha de lavado.',
            'tipo_purgante.required_with'     => 'Ingresa el tipo de purgante si registras una fecha de purga.',
        ]);

        // Al menos una sección debe tener datos
        if (empty($validated['fecha_lavado']) && empty($validated['fecha_purga'])) {
            return back()->withInput()->withErrors([
                'seccion' => 'Debes completar al menos una sección: Lavado o Purga.',
            ]);
        }

        $animal->healthRecords()->create([
            ...$validated,
            'aplicado_por' => Auth::id(),
        ]);

        return redirect()
            ->route('animals.health.index', $animal)
            ->with('success', 'Registro sanitario guardado para ' . ($animal->nombre ? $animal->nombre : $animal->codigo_nfc) . '.');
    }

    /**
     * Guardar registros sanitarios en lote para múltiples animales.
     */
    public function storeBatch(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'animal_ids' => 'required|array|min:1',
            'animal_ids.*' => 'integer|exists:animals,id',
            // Lavado
            'fecha_lavado'    => 'nullable|date|before_or_equal:today',
            'producto_lavado' => 'nullable|string|max:255|required_with:fecha_lavado',
            'producto_lavado_secundario' => 'nullable|string|max:255',
            // Purga (opcional pero per-animal sigue siendo la vía recomendada)
            'fecha_purga'     => 'nullable|date|before_or_equal:today',
            'tipo_purgante'   => 'nullable|string|max:255|required_with:fecha_purga',
            // General
            'observaciones'   => 'nullable|string|max:1000',
        ], [
            'fecha_lavado.before_or_equal'    => 'La fecha de lavado no puede ser futura.',
            'fecha_purga.before_or_equal'     => 'La fecha de purga no puede ser futura.',
            'producto_lavado.required_with'   => 'Ingresa el producto si registras una fecha de lavado.',
            'tipo_purgante.required_with'     => 'Ingresa el tipo de purgante si registras una fecha de purga.',
        ]);

        if (empty($validated['fecha_lavado']) && empty($validated['fecha_purga'])) {
            return back()->withInput()->withErrors([
                'seccion' => 'Debes completar al menos una sección: Lavado o Purga.',
            ]);
        }

        $data = [
            'fecha_lavado' => $validated['fecha_lavado'] ?? null,
            'producto_lavado' => $validated['producto_lavado'] ?? null,
            'producto_lavado_secundario' => $validated['producto_lavado_secundario'] ?? null,
            'fecha_purga' => $validated['fecha_purga'] ?? null,
            'tipo_purgante' => $validated['tipo_purgante'] ?? null,
            'observaciones' => $validated['observaciones'] ?? null,
            'aplicado_por' => Auth::id(),
        ];

        foreach ($validated['animal_ids'] as $aid) {
            $animal = Animal::find($aid);
            if ($animal) {
                $animal->healthRecords()->create($data);
            }
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Registros sanitarios guardados para ' . count($validated['animal_ids']) . ' animales.');
    }

    // ─── Formulario de edición ─────────────────────────────────

    public function edit(Animal $animal, AnimalHealthRecord $health): View
    {
        abort_if($health->animal_id !== $animal->id, 404);

        return view('admin.sanitario.edit', compact('animal', 'health'));
    }

    // ─── Actualizar ────────────────────────────────────────────

    public function update(Request $request, Animal $animal, AnimalHealthRecord $health): RedirectResponse
    {
        abort_if($health->animal_id !== $animal->id, 404);

        $validated = $request->validate([
            'fecha_lavado'    => 'nullable|date|before_or_equal:today',
            'producto_lavado' => 'nullable|string|max:255|required_with:fecha_lavado',
            'producto_lavado_secundario' => 'nullable|string|max:255',
            'fecha_purga'     => 'nullable|date|before_or_equal:today',
            'tipo_purgante'   => 'nullable|string|max:255|required_with:fecha_purga',
            'observaciones'   => 'nullable|string|max:1000',
        ], [
            'fecha_lavado.before_or_equal'  => 'La fecha de lavado no puede ser futura.',
            'fecha_purga.before_or_equal'   => 'La fecha de purga no puede ser futura.',
            'producto_lavado.required_with' => 'Ingresa el producto si registras una fecha de lavado.',
            'tipo_purgante.required_with'   => 'Ingresa el tipo de purgante si registras una fecha de purga.',
        ]);

        if (empty($validated['fecha_lavado']) && empty($validated['fecha_purga'])) {
            return back()->withInput()->withErrors([
                'seccion' => 'Debes completar al menos una sección: Lavado o Purga.',
            ]);
        }

        $health->update($validated);

        return redirect()
            ->route('animals.health.index', $animal)
            ->with('success', 'Registro sanitario actualizado correctamente.');
    }

    // ─── Eliminar ──────────────────────────────────────────────

    public function destroy(Animal $animal, AnimalHealthRecord $health): RedirectResponse
    {
        abort_if($health->animal_id !== $animal->id, 404);

        $health->delete();

        return redirect()
            ->route('animals.health.index', $animal)
            ->with('success', 'Registro sanitario eliminado.');
    }
}