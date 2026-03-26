<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalReproductiveRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnimalReproductiveRecordController extends Controller
{
    // ─── Listado ───────────────────────────────────────────────

    public function index(Animal $animal): View
    {
        $records = $animal->reproductiveRecords()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.reproductivo.index', compact('animal', 'records'));
    }

    // ─── Formulario de creación ────────────────────────────────

    public function create(Animal $animal): View
    {
        $tiposProceso = AnimalReproductiveRecord::TIPOS_PROCESO;

        return view('admin.reproductivo.create', compact('animal', 'tiposProceso'));
    }

    // ─── Guardar ───────────────────────────────────────────────

    public function store(Request $request, Animal $animal): RedirectResponse
    {
        $validated = $request->validate([
            // Palpación
            'palpacion'               => 'boolean',
            'fecha_palpacion'         => 'nullable|date|before_or_equal:today',
            'observaciones_palpacion' => 'nullable|string|max:1000',
            // Dosis
            'dosis_reproductiva'      => 'nullable|string|max:255',
            'fecha_dosis'             => 'nullable|date|before_or_equal:today',
            // Proceso
            'tipo_proceso'            => 'nullable|in:embrion,inseminacion,monta_natural',
            'fecha_prenez'            => 'nullable|date|before_or_equal:today',
            // Nacimiento
            'fecha_estimada_parto'    => [
                'nullable',
                'date',
                'after:fecha_prenez',   // el parto siempre es posterior a la preñez
            ],
            // Generales
            'observaciones'           => 'nullable|string|max:1000',
        ], [
            'fecha_palpacion.before_or_equal'  => 'La fecha de palpación no puede ser futura.',
            'fecha_dosis.before_or_equal'      => 'La fecha de dosis no puede ser futura.',
            'fecha_prenez.before_or_equal'     => 'La fecha de preñez no puede ser futura.',
            'fecha_estimada_parto.after'       => 'La fecha estimada de parto debe ser posterior a la fecha de preñez.',
        ]);

        // Normalizar el checkbox boolean
        $validated['palpacion'] = $request->boolean('palpacion');

        // Regla de negocio: si marcó palpación, la fecha es obligatoria
        if ($validated['palpacion'] && empty($validated['fecha_palpacion'])) {
            return back()->withInput()->withErrors([
                'fecha_palpacion' => 'Si se realizó palpación, la fecha es obligatoria.',
            ]);
        }

        $animal->reproductiveRecords()->create([
            ...$validated,
            'registrado_por' => Auth::id(),
        ]);

        return redirect()
            ->route('animals.reproductive.index', $animal)
            ->with('success', 'Proceso reproductivo registrado para ' . ($animal->nombre ?? $animal->codigo_nfc) . '.');
    }

    // ─── Detalle ───────────────────────────────────────────────

    public function show(Animal $animal, AnimalReproductiveRecord $reproductive): View
    {
        abort_if($reproductive->animal_id !== $animal->id, 404);

        return view('admin.reproductivo.show', compact('animal', 'reproductive'));
    }

    // ─── Formulario de edición ─────────────────────────────────

    public function edit(Animal $animal, AnimalReproductiveRecord $reproductive): View
    {
        abort_if($reproductive->animal_id !== $animal->id, 404);

        $tiposProceso = AnimalReproductiveRecord::TIPOS_PROCESO;

        return view('admin.reproductivo.edit', compact('animal', 'reproductive', 'tiposProceso'));
    }

    // ─── Actualizar ────────────────────────────────────────────

    public function update(Request $request, Animal $animal, AnimalReproductiveRecord $reproductive): RedirectResponse
    {
        abort_if($reproductive->animal_id !== $animal->id, 404);

        $validated = $request->validate([
            'palpacion'               => 'boolean',
            'fecha_palpacion'         => 'nullable|date|before_or_equal:today',
            'observaciones_palpacion' => 'nullable|string|max:1000',
            'dosis_reproductiva'      => 'nullable|string|max:255',
            'fecha_dosis'             => 'nullable|date|before_or_equal:today',
            'tipo_proceso'            => 'nullable|in:embrion,inseminacion,monta_natural',
            'fecha_prenez'            => 'nullable|date|before_or_equal:today',
            'fecha_estimada_parto'    => ['nullable', 'date', 'after:fecha_prenez'],
            'observaciones'           => 'nullable|string|max:1000',
        ], [
            'fecha_palpacion.before_or_equal'  => 'La fecha de palpación no puede ser futura.',
            'fecha_dosis.before_or_equal'      => 'La fecha de dosis no puede ser futura.',
            'fecha_prenez.before_or_equal'     => 'La fecha de preñez no puede ser futura.',
            'fecha_estimada_parto.after'       => 'La fecha estimada de parto debe ser posterior a la fecha de preñez.',
        ]);

        $validated['palpacion'] = $request->boolean('palpacion');

        if ($validated['palpacion'] && empty($validated['fecha_palpacion'])) {
            return back()->withInput()->withErrors([
                'fecha_palpacion' => 'Si se realizó palpación, la fecha es obligatoria.',
            ]);
        }

        $reproductive->update($validated);

        return redirect()
            ->route('animals.reproductive.index', $animal)
            ->with('success', 'Proceso reproductivo actualizado correctamente.');
    }

    // ─── Eliminar ──────────────────────────────────────────────

    public function destroy(Animal $animal, AnimalReproductiveRecord $reproductive): RedirectResponse
    {
        abort_if($reproductive->animal_id !== $animal->id, 404);

        $reproductive->delete();

        return redirect()
            ->route('animals.reproductive.index', $animal)
            ->with('success', 'Registro reproductivo eliminado.');
    }
}