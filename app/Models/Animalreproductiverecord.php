<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimalReproductiveRecord extends Model
{
    protected $fillable = [
        'animal_id',
        // Palpación
        'palpacion',
        'fecha_palpacion',
        'observaciones_palpacion',
        // Dosis
        'dosis_reproductiva',
        'fecha_dosis',
        // Proceso
        'tipo_proceso',
        'fecha_insercion',
        'fecha_prenez',
        // Nacimiento
        'fecha_estimada_parto',
        // Re-palpación / seguimiento
        'repalpacion',
        'fecha_repalpacion',
        'repalpacion_efectiva',
        // Generales
        'observaciones',
        'registrado_por',
    ];

    protected $casts = [
        'palpacion'            => 'boolean',
        'fecha_palpacion'      => 'date',
        'fecha_dosis'          => 'date',
        'fecha_prenez'         => 'date',
        'fecha_estimada_parto' => 'date',
        'fecha_insercion'      => 'date',
        'fecha_repalpacion'    => 'date',
        'repalpacion'          => 'boolean',
        'repalpacion_efectiva' => 'boolean',
    ];

    // ─── Labels para el enum tipo_proceso ─────────────────────

    public const TIPOS_PROCESO = [
        'embrion'       => 'Embrión',
        'inseminacion'  => 'Inseminación Artificial',
        'monta_natural' => 'Monta Natural',
    ];

    /**
     * Devuelve la etiqueta legible del tipo de proceso.
     */
    public function getTipoProcesoLabelAttribute(): string
    {
        return self::TIPOS_PROCESO[$this->tipo_proceso] ?? '—';
    }

    /**
     * Calcula los días de gestación estimados desde fecha_prenez
     * hasta fecha_estimada_parto. Útil para mostrar en la vista.
     */
    public function getDiasGestacionAttribute(): ?int
    {
        if ($this->fecha_prenez && $this->fecha_estimada_parto) {
            return (int) $this->fecha_prenez->diffInDays($this->fecha_estimada_parto);
        }
        return null;
    }

    // ─── Relaciones ───────────────────────────────────────────

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}