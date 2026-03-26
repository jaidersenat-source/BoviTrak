<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimalVaccination extends Model
{
    protected $fillable = [
        'animal_id',
        'vacuna',
        'dosis',
        'fecha_vacunacion',
        'lote',
        'aplicado_por',
        'nota',
    ];

    protected $casts = [
        'fecha_vacunacion' => 'date',
    ];

    // ─── Relaciones ───────────────────────────────────────────

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function aplicador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aplicado_por');
    }
}