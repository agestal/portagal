<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Puerta extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre'
    ];
    public function presupuesto() : BelongsTo
    {
        return $this->belongsTo(Presupuesto::class);
    }
    public function tipomotors() : HasMany
    {
        return $this->hasMany(TipoMotor::class);
    }
}
