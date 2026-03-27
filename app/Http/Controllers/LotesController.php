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
