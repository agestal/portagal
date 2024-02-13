<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Funcionamiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'automatico'
    ];
    public function opcionpresupuesto(): HasMany
    {
        return $this->hasMany(OpcionPresupuesto::class);
    }
}
