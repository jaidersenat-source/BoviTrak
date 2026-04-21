<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ceba extends Model
{
    protected $table = 'cebas';

    protected $fillable = [
        'animal_id', 'fecha_ingreso', 'peso_inicial', 'peso_objetivo', 'destino_lote', 'observaciones'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function registros()
    {
        return $this->hasMany(CebaRegistro::class)->orderBy('medido_el');
    }
}
