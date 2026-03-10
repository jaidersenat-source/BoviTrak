<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalPhoto extends Model
{
    protected $fillable = [
        'animal_id',
        'photo_path',
        'type',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
