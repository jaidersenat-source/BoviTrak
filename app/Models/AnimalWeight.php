<?php
// app/Models/AnimalWeight.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimalWeight extends Model
{
    protected $fillable = [
        'animal_id',
        'peso',
        'measured_at',
        'recorded_by',
        'nota',
    ];

    protected $casts = [
        'measured_at' => 'date',
        'peso'        => 'decimal:2',
    ];

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}