<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Animal extends Model
{
    protected $fillable = [
        'codigo_nfc',
        'nombre',
        'raza',
        'sexo',
        'fecha_nacimiento',
        'peso_aproximado',
        'color',
        'observaciones',
        'public_token',
        'foto_boca',
        'foto_general',
    ];

    public function photos()
    {
        return $this->hasMany(AnimalPhoto::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($animal) {
            if (empty($animal->public_token)) {
                $animal->public_token = (string) Str::uuid();
            }
        });
    }
}
