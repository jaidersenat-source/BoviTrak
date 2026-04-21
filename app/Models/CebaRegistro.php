<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CebaRegistro extends Model
{
    protected $table = 'ceba_registros';

    protected $fillable = [
        'ceba_id', 'medido_el', 'peso', 'tipo_alimento', 'cantidad_alimento', 'observaciones'
    ];

    public function ceba()
    {
        return $this->belongsTo(Ceba::class);
    }
}
