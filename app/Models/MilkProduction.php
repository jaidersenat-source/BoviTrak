<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MilkProduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_id',
        'date',
        'liters',
        'shift',
        'somatic_cells',
        'mastitis',
        'coagulos',
        'nipple_damage',
        'nipple_damage_notes',
        'duct_blockage',
        'treatment_dose',
        'treatment_date',
        'treatment_next_date',
        'treatment_estimated_days',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date',
        'liters' => 'decimal:2',
        'mastitis' => 'boolean',
        'coagulos' => 'boolean',
        'nipple_damage' => 'boolean',
        'duct_blockage' => 'boolean',
        'treatment_date' => 'date',
        'treatment_next_date' => 'date',
        'somatic_cells' => 'integer',
    ];

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
