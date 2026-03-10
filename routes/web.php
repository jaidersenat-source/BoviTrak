<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GanadoController;
use App\Http\Controllers\PublicAnimalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [GanadoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Ruta pública para ver animales (sin autenticación)
Route::get('/public/animal/{token}', [PublicAnimalController::class, 'show'])->name('public.animal.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de Ganado - Protegidas con middleware admin adicional
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::prefix('ganado')->name('ganado.')->group(function () {
            Route::get('create', [GanadoController::class, 'create'])->name('create');
            Route::post('/', [GanadoController::class, 'store'])->name('store');
            Route::get('{ganado}', [GanadoController::class, 'show'])->name('show');
            Route::get('{ganado}/edit', [GanadoController::class, 'edit'])->name('edit');
            Route::put('{ganado}', [GanadoController::class, 'update'])->name('update');
            Route::delete('{ganado}', [GanadoController::class, 'destroy'])->name('destroy');
        });
    });
});



require __DIR__.'/auth.php';
