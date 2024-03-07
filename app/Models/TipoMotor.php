<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoMotor extends Model
{
    use HasFactory;
    protected $table = 'tipo_motor';
    protected $fillable = [
        'nombre'
    ];
    public function motors() : HasMany
    {
        return $this->hasMany(Motor::class);
    }
    public function presupuestos()
    {
        return $this->belongsToMany(Presupuesto::class);
    }
}
