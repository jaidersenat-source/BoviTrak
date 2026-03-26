<?php
// app/Http/Controllers/AnimalWeightController.php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalWeight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimalWeightController extends Controller
{
    public function index(int $animalId)
    {
        $animal = Animal::findOrFail($animalId);

        $weights = $animal->weights()
                          ->orderByDesc('measured_at')
                          ->paginate(15);

        return view('admin.weights.index', compact('animal', 'weights'));
    }

    public function store(Request $request, int $animalId)
    {
        $animal = Animal::findOrFail($animalId);

        $validated = $request->validate([
            'peso'        => ['required', 'numeric', 'min:0.5', 'max:2000'],
            'measured_at' => ['required', 'date', 'before_or_equal:today'],
            'nota'        => ['nullable', 'string', 'max:1000'],
        ]);

        $animal->weights()->create([
            ...$validated,
            'recorded_by' => Auth::id(),
        ]);

        return redirect()
            ->route('animals.weights.index', $animal->id)
            ->with('success', 'Peso registrado correctamente.');
    }
}