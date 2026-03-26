<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GanadoController;
use App\Http\Controllers\PublicAnimalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalWeightController;
use App\Http\Controllers\AnimalVaccinationController;
use App\Http\Controllers\AnimalHealthRecordController;
use App\Http\Controllers\AnimalReproductiveRecordController;
use App\Http\Controllers\AnimalDescendanceController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ruta pública para ver animales (sin autenticación)
Route::get('/public/animal/{token}', [PublicAnimalController::class, 'show'])->name('public.animal.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('animals/{animal}')->name('animals.')->group(function () {
        Route::get('/weights',  [AnimalWeightController::class, 'index'])->name('weights.index');
        Route::post('/weights', [AnimalWeightController::class, 'store'])->name('weights.store');
    

            // ── NUEVO: Vacunaciones ──────────────────────────────────────
    Route::get('/vacunaciones',                    [AnimalVaccinationController::class, 'index'])->name('vaccinations.index');
    Route::get('/vacunaciones/create',             [AnimalVaccinationController::class, 'create'])->name('vaccinations.create');
    Route::post('/vacunaciones',                   [AnimalVaccinationController::class, 'store'])->name('vaccinations.store');
    Route::get('/vacunaciones/{vaccination}/edit', [AnimalVaccinationController::class, 'edit'])->name('vaccinations.edit');
    Route::put('/vacunaciones/{vaccination}',      [AnimalVaccinationController::class, 'update'])->name('vaccinations.update');
    Route::delete('/vacunaciones/{vaccination}',   [AnimalVaccinationController::class, 'destroy'])->name('vaccinations.destroy');

    // ── NUEVO: Registro Sanitario ────────────────────────────────
    Route::get('/sanitario',               [AnimalHealthRecordController::class, 'index'])->name('health.index');
    Route::get('/sanitario/create',        [AnimalHealthRecordController::class, 'create'])->name('health.create');
    Route::post('/sanitario',              [AnimalHealthRecordController::class, 'store'])->name('health.store');
    Route::get('/sanitario/{health}/edit', [AnimalHealthRecordController::class, 'edit'])->name('health.edit');
    Route::put('/sanitario/{health}',      [AnimalHealthRecordController::class, 'update'])->name('health.update');
    Route::delete('/sanitario/{health}',   [AnimalHealthRecordController::class, 'destroy'])->name('health.destroy');

    // ── NUEVO: Proceso Reproductivo ──────────────────────────────
    Route::get('/reproductivo',                        [AnimalReproductiveRecordController::class, 'index'])->name('reproductive.index');
    Route::get('/reproductivo/create',                 [AnimalReproductiveRecordController::class, 'create'])->name('reproductive.create');
    Route::post('/reproductivo',                       [AnimalReproductiveRecordController::class, 'store'])->name('reproductive.store');
    Route::get('/reproductivo/{reproductive}',         [AnimalReproductiveRecordController::class, 'show'])->name('reproductive.show');
    Route::get('/reproductivo/{reproductive}/edit',    [AnimalReproductiveRecordController::class, 'edit'])->name('reproductive.edit');
    Route::put('/reproductivo/{reproductive}',         [AnimalReproductiveRecordController::class, 'update'])->name('reproductive.update');
    Route::delete('/reproductivo/{reproductive}',      [AnimalReproductiveRecordController::class, 'destroy'])->name('reproductive.destroy');

    // ── NUEVO: Registro de Descendencia ─────────────────────────
    Route::get('/descendencia',                        [AnimalDescendanceController::class, 'index'])->name('descendencia.index');
    Route::get('/descendencia/create',                 [AnimalDescendanceController::class, 'create'])->name('descendencia.create');
    Route::post('/descendencia',                       [AnimalDescendanceController::class, 'store'])->name('descendencia.store');
    Route::get('/descendencia/{record}',               [AnimalDescendanceController::class, 'show'])->name('descendencia.show');
    Route::get('/descendencia/{record}/edit',          [AnimalDescendanceController::class, 'edit'])->name('descendencia.edit');
    Route::put('/descendencia/{record}',               [AnimalDescendanceController::class, 'update'])->name('descendencia.update');
    Route::delete('/descendencia/{record}',            [AnimalDescendanceController::class, 'destroy'])->name('descendencia.destroy');
 

 
}); // ← cierra animals

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::prefix('ganado')->name('ganado.')->group(function () {
            Route::get('/', [GanadoController::class, 'index'])->name('index');
            Route::get('create', [GanadoController::class, 'create'])->name('create');
            Route::post('/', [GanadoController::class, 'store'])->name('store');
            Route::get('{ganado}', [GanadoController::class, 'show'])->name('show');
            Route::get('{ganado}/edit', [GanadoController::class, 'edit'])->name('edit');
            Route::put('{ganado}', [GanadoController::class, 'update'])->name('update');
            Route::delete('{ganado}', [GanadoController::class, 'destroy'])->name('destroy');
        }); // ← cierra ganado
    }); // ← cierra admin

});


require __DIR__.'/auth.php';
