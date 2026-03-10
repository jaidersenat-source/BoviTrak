<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GanadoController extends Controller
{
    /**
     * Mostrar el listado de ganado en el dashboard
     */
    public function index(Request $request)
    {
        $query = Animal::select('id', 'codigo_nfc', 'nombre', 'raza', 'sexo', 'public_token', 'created_at');
        
        // Filtrar por búsqueda si existe
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('codigo_nfc', 'like', '%' . $search . '%')
                  ->orWhere('raza', 'like', '%' . $search . '%')
                  ->orWhere('nombre', 'like', '%' . $search . '%');
            });
        }
        
        // Paginación para mejorar rendimiento - 12 animales por página
        $animals = $query->orderBy('created_at', 'desc')->paginate(12);
        
        return view('dashboard', compact('animals'));
    }

    /**
     * Mostrar el formulario para crear un nuevo ganado
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Guardar un nuevo ganado en la base de datos
     */
    public function store(Request $request)
    {
        try {
            // Validación
            $validated = $request->validate([
                'codigo_nfc' => 'required|string|unique:animals,codigo_nfc',
                'nombre' => 'nullable|string|max:255',
                'raza' => 'required|string|max:255',
                'sexo' => 'required|in:macho,hembra',
                'fecha_nacimiento' => 'nullable|date',
                'peso_aproximado' => 'nullable|numeric|min:0',
                'color' => 'nullable|string|max:255',
                'observaciones' => 'nullable|string',
                'foto_boca' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
                'foto_general' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'fotos_adicionales.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            ]);

            // Crear el animal (el public_token se genera automáticamente en el modelo)
            $animal = Animal::create([
                'codigo_nfc' => $validated['codigo_nfc'],
                'nombre' => $validated['nombre'] ?? null,
                'raza' => $validated['raza'],
                'sexo' => $validated['sexo'],
                'fecha_nacimiento' => $validated['fecha_nacimiento'] ?? null,
                'peso_aproximado' => $validated['peso_aproximado'] ?? null,
                'color' => $validated['color'] ?? null,
                'observaciones' => $validated['observaciones'] ?? null,
            ]);

            // Guardar foto de la boca
            if ($request->hasFile('foto_boca')) {
                $path = $request->file('foto_boca')->store('animals/boca', 'public');
                $animal->update(['foto_boca' => $path]);
            }

            // Guardar foto general
            if ($request->hasFile('foto_general')) {
                $path = $request->file('foto_general')->store('animals/general', 'public');
                $animal->update(['foto_general' => $path]);
            }

            // Guardar fotos adicionales (si existe la tabla animal_photos)
            if ($request->hasFile('fotos_adicionales')) {
                foreach ($request->file('fotos_adicionales') as $foto) {
                    $path = $foto->store('animals/adicionales', 'public');
                    // Aquí podrías guardar en la tabla animal_photos si existe
                    // $animal->photos()->create(['photo_path' => $path, 'type' => 'adicional']);
                }
            }

            return redirect()->route('dashboard')->with([
                'success' => 'Ganado registrado correctamente.',
                'animal_saved' => [
                    'id' => $animal->id,
                    'codigo_nfc' => $animal->codigo_nfc,
                    'raza' => $animal->raza,
                ],
                'action_type' => 'created'
            ]);
            
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalles de un ganado
     */
    public function show($id)
    {
        $animal = Animal::findOrFail($id);
        return view('admin.show', compact('animal'));
    }

    /**
     * Mostrar el formulario para editar un ganado
     */
    public function edit($id)
    {
        $animal = Animal::findOrFail($id);
        return view('admin.edit', compact('animal'));
    }

    /**
     * Actualizar un ganado existente
     */
    public function update(Request $request, $id)
    {
        try {
            $animal = Animal::findOrFail($id);

            $validated = $request->validate([
                'codigo_nfc' => 'required|string|unique:animals,codigo_nfc,' . $id,
                'nombre' => 'nullable|string|max:255',
                'raza' => 'required|string|max:255',
                'sexo' => 'required|in:macho,hembra',
                'fecha_nacimiento' => 'nullable|date',
                'peso_aproximado' => 'nullable|numeric|min:0',
                'color' => 'nullable|string|max:255',
                'observaciones' => 'nullable|string',
                'foto_boca' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'foto_general' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            ]);

            // Actualizar datos básicos
            $animal->update([
                'codigo_nfc' => $validated['codigo_nfc'],
                'nombre' => $validated['nombre'] ?? null,
                'raza' => $validated['raza'],
                'sexo' => $validated['sexo'],
                'fecha_nacimiento' => $validated['fecha_nacimiento'] ?? null,
                'peso_aproximado' => $validated['peso_aproximado'] ?? null,
                'color' => $validated['color'] ?? null,
                'observaciones' => $validated['observaciones'] ?? null,
            ]);

            // Actualizar foto de la boca si se subió una nueva
            if ($request->hasFile('foto_boca')) {
                // Eliminar foto anterior si existe
                if ($animal->foto_boca && Storage::disk('public')->exists($animal->foto_boca)) {
                    Storage::disk('public')->delete($animal->foto_boca);
                }
                $path = $request->file('foto_boca')->store('animals/boca', 'public');
                $animal->update(['foto_boca' => $path]);
            }

            // Actualizar foto general si se subió una nueva
            if ($request->hasFile('foto_general')) {
                // Eliminar foto anterior si existe
                if ($animal->foto_general && Storage::disk('public')->exists($animal->foto_general)) {
                    Storage::disk('public')->delete($animal->foto_general);
                }
                $path = $request->file('foto_general')->store('animals/general', 'public');
                $animal->update(['foto_general' => $path]);
            }

            return redirect()->route('dashboard')->with([
                'success' => 'Ganado actualizado correctamente.',
                'animal_saved' => [
                    'id' => $animal->id,
                    'codigo_nfc' => $animal->codigo_nfc,
                    'raza' => $animal->raza,
                ],
                'action_type' => 'updated'
            ]);
            
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar un ganado
     */
    public function destroy($id)
    {
        $animal = Animal::findOrFail($id);
        $animal->delete();

        return redirect()->route('dashboard')->with('success', 'Ganado eliminado correctamente.');
    }
}
