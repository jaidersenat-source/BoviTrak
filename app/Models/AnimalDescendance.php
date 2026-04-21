<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimalDescendance extends Model
{
    use HasFactory;

    /**
     * Tabla asociada.
     *
     * @var string
     */
    protected $table = 'animal_descendances';

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'animal_id',
        'padre_id',
        'madre_id',
        'padre_nombre',
        'padre_raza',
        'madre_nombre',
        'madre_raza',
        'fecha_nacimiento',
        'observaciones',
        'registrado_por',
    ];

    /**
     * Casts.
     *
     * @var array
     */
    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    /**
     * Hijo.
     */
    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    /**
     * Padre (toro).
     */
    public function padre(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'padre_id');
    }

    /**
     * Madre (vaca).
     */
    public function madre(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'madre_id');
    }

    /**
     * Usuario que registró.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}
