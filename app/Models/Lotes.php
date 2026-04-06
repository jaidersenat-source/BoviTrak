<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lotes extends Model
{
    use HasFactory;

    protected $table = 'lotes';

    protected $fillable = [
        'codigo',
        'nombre_pastura',
        'banco_nutricional',
        'tiempo_ocupacion_dias',
        'tiempo_descanso_dias',
        'aplicacion_abonos',
        'fecha_roceria',
        'fecha_inicio_ocupacion',
        'jornales',
        'area_ha',
        'observaciones',
        'user_id',
    ];

    protected $casts = [
        'tiempo_ocupacion_dias' => 'integer',
        'tiempo_descanso_dias' => 'integer',
        'fecha_roceria' => 'date',
        'fecha_inicio_ocupacion' => 'date',
        'jornales' => 'integer',
        'area_ha' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
