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
        'notes',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date',
        'liters' => 'decimal:2',
        'mastitis' => 'boolean',
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
