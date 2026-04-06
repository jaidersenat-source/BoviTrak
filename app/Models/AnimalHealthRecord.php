<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimalHealthRecord extends Model
{
    protected $fillable = [
        'animal_id',
        // Sección 1
        'fecha_lavado',
        'producto_lavado',
        'producto_lavado_secundario',
        // Sección 2
        'fecha_purga',
        'tipo_purgante',
        // Generales
        'observaciones',
        'aplicado_por',
    ];

    protected $casts = [
        'fecha_lavado' => 'date',
        'fecha_purga'  => 'date',
    ];

    // ─── Relaciones ───────────────────────────────────────────

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aplicado_por');
    }

    // ─── Helpers ──────────────────────────────────────────────

    /**
     * Determina qué tipo de registro sanitario es,
     * útil para mostrar etiquetas en el listado.
     */
    public function getTipoAttribute(): string
    {
        if ($this->fecha_lavado && $this->fecha_purga) {
            return 'Lavado + Purga';
        }
        if ($this->fecha_lavado) {
            return 'Lavado Antiparasitario';
        }
        if ($this->fecha_purga) {
            return 'Purga';
        }
        return 'Sin tipo';
    }
}