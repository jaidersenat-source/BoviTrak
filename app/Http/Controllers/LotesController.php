<?php

namespace App\Http\Controllers;

use App\Models\Lotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LotesController extends Controller
{
    public function index()
    {
        $lotes = Lotes::with('user')->orderByDesc('created_at')->paginate(15);

        // Calcular alertas de rotación para cada lote
        foreach ($lotes as $lote) {
            $restDays = $lote->tiempo_descanso_dias ?? 30;
            // Preferir fecha_roceria; si no existe, usar fecha_inicio_ocupacion como referencia
            $base = $lote->fecha_roceria ?? $lote->fecha_inicio_ocupacion ?? null;
            if ($base) {
                $restUntil = \Carbon\Carbon::parse($base)->addDays($restDays);
                $lote->rest_until = $restUntil;
                $lote->dias_restantes = now()->diffInDays($restUntil, false);
                $lote->is_resting = now()->lessThanOrEqualTo($restUntil);
            } else {
                $lote->rest_until = null;
                $lote->dias_restantes = null;
                $lote->is_resting = false;
            }
        }

        return view('admin.lotes.index', compact('lotes'));
    }

    public function create()
    {
        return view('admin.lotes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo' => 'required|string|max:50|unique:lotes,codigo',
            'nombre_pastura' => 'nullable|string|max:191',
            'banco_nutricional' => 'nullable|string',
            'tiempo_ocupacion_dias' => 'nullable|integer|min:0',
            'tiempo_descanso_dias' => 'nullable|integer|min:0',
            'aplicacion_abonos' => 'nullable|string',
            'area_ha' => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string',
            'fecha_roceria' => 'nullable|date|before_or_equal:today',
            'fecha_inicio_ocupacion' => 'nullable|date|before_or_equal:today',
            'jornales' => 'nullable|integer|min:0',
        ]);

        $data['user_id'] = Auth::id();

        Lotes::create($data);

        return Redirect::route('admin.lotes.index')->with('success', 'Lote creado correctamente.');
    }

    public function show(Lotes $lote)
    {
        return view('admin.lotes.show', compact('lote'));
    }

    public function edit(Lotes $lote)
    {
        return view('admin.lotes.edit', compact('lote'));
    }

    public function update(Request $request, Lotes $lote)
    {
        $data = $request->validate([
            'codigo' => ['required','string','max:50', Rule::unique('lotes')->ignore($lote->id)],
            'nombre_pastura' => 'nullable|string|max:191',
            'banco_nutricional' => 'nullable|string',
            'tiempo_ocupacion_dias' => 'nullable|integer|min:0',
            'tiempo_descanso_dias' => 'nullable|integer|min:0',
            'aplicacion_abonos' => 'nullable|string',
            'area_ha' => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string',
            'fecha_roceria' => 'nullable|date|before_or_equal:today',
            'fecha_inicio_ocupacion' => 'nullable|date|before_or_equal:today',
            'jornales' => 'nullable|integer|min:0',
        ]);

        $lote->update($data);

        return Redirect::route('admin.lotes.show', $lote)->with('success', 'Lote actualizado correctamente.');
    }

    public function destroy(Lotes $lote)
    {
        $lote->delete();
        return Redirect::route('admin.lotes.index')->with('success', 'Lote eliminado.');
    }
}
