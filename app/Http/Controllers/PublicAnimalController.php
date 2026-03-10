<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class PublicAnimalController extends Controller
{
    /**
     * Mostrar la información pública de un animal usando su token público
     */
    public function show($token)
    {
        // Buscar el animal por su token público
        $animal = Animal::where('public_token', $token)->firstOrFail();

        // Retornar vista pública sin layout de autenticación
        return view('public.animal-show', compact('animal'));
    }
}
