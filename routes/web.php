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
use App\Http\Controllers\LotesController;
use App\Http\Controllers\MilkProductionController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Ruta pública para ver animales (sin autenticación)
Route::get('/public/animal/{token}', [PublicAnimalController::class, 'show'])->name('public.animal.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('animals/{animal}')->name('animals.')->group(function () {
        Route::get('/weights',  [AnimalWeightController::class, 'index'])->name('weights.index');
        Route::post('/weights', [AnimalWeightController::class, 'store'])->name('weights.store');
        Route::post('/weights/frecuencia', [AnimalWeightController::class, 'setFrequency'])->name('weights.setFrequency');
    

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

    // Rutas para registro en lote (lavado de lote)
    Route::get('/sanitario/lote/create',   [AnimalHealthRecordController::class, 'createBatch'])->name('health.batch.create');
    Route::post('/sanitario/lote',         [AnimalHealthRecordController::class, 'storeBatch'])->name('health.batch.store');

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
 
    // ── NUEVO: Producción de Leche ──────────────────────────────
    Route::get('/leche',                        [MilkProductionController::class, 'index'])->name('milk.index');
    Route::get('/leche/create',                 [MilkProductionController::class, 'create'])->name('milk.create');
    Route::post('/leche',                       [MilkProductionController::class, 'store'])->name('milk.store');
    Route::get('/leche/{milk}',                 [MilkProductionController::class, 'show'])->name('milk.show');
    Route::get('/leche/{milk}/edit',            [MilkProductionController::class, 'edit'])->name('milk.edit');
    Route::put('/leche/{milk}',                 [MilkProductionController::class, 'update'])->name('milk.update');
    Route::delete('/leche/{milk}',              [MilkProductionController::class, 'destroy'])->name('milk.destroy');

    // Registro de Lotes: ahora manejado como módulo independiente (rutas en /admin/lotes)


 
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

        // Rutas de Lotes como módulo independiente bajo /admin/lotes
        Route::prefix('lotes')->name('lotes.')->group(function () {
            Route::get('/', [LotesController::class, 'index'])->name('index');
            Route::get('create', [LotesController::class, 'create'])->name('create');
            Route::post('/', [LotesController::class, 'store'])->name('store');
            Route::get('{lote}', [LotesController::class, 'show'])->name('show');
            Route::get('{lote}/edit', [LotesController::class, 'edit'])->name('edit');
            Route::put('{lote}', [LotesController::class, 'update'])->name('update');
            Route::delete('{lote}', [LotesController::class, 'destroy'])->name('destroy');
        });
    }); // ← cierra admin

});


require __DIR__.'/auth.php';
