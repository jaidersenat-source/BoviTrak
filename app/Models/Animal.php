<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\AnimalWeight;
use App\Models\AnimalVaccination;
use App\Models\AnimalHealthRecord;
use App\Models\AnimalReproductiveRecord;
use App\Models\AnimalDescendance;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Animal extends Model
{
    protected $fillable = [
        'codigo_nfc',
        'nombre',
        'raza',
        'sexo',
        'proposito',
        'estado',
        'fecha_nacimiento',
        'fecha_ingreso_hato',
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

    // Dentro de la clase Animal:
public function weights(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(AnimalWeight::class)->orderByDesc('measured_at');
}

public function latestWeight(): \Illuminate\Database\Eloquent\Relations\HasOne
{
    return $this->hasOne(AnimalWeight::class)->latestOfMany('measured_at');
}

public function vaccinations()
{
    return $this->hasMany(AnimalVaccination::class);
}
 
public function healthRecords()
{
    return $this->hasMany(AnimalHealthRecord::class);
}

public function reproductiveRecords()
{
    return $this->hasMany(AnimalReproductiveRecord::class);
}
 
// 3. Accessor opcional: obtener el último proceso activo
public function getUltimoProcesoReproductivoAttribute(): ?AnimalReproductiveRecord
{
    return $this->reproductiveRecords()
                ->latest()
                ->first();
}

    /**
     * Relación: registros de descendencia donde este animal es el hijo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descendances(): HasMany
    {
        return $this->hasMany(AnimalDescendance::class, 'animal_id');
    }

    /**
     * Relación: obtener el último registro de descendencia (padres) de este animal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parentage(): HasOne
    {
        return $this->hasOne(AnimalDescendance::class, 'animal_id')->latestOfMany();
    }

    /**
     * Relación: registros donde este animal figura como padre (toro).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asPadre(): HasMany
    {
        return $this->hasMany(AnimalDescendance::class, 'padre_id');
    }

    /**
     * Relación: registros donde este animal figura como madre (vaca).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asMadre(): HasMany
    {
        return $this->hasMany(AnimalDescendance::class, 'madre_id');
    }

}
