<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Motor extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'tipo_id'
    ];
    public function tipomotors() : BelongsTo
    {
        return $this->belongsTo(TipoMotor::class);
    }
    public function presupuestos() : BelongsToMany
    {
        return $this->belongsToMany(Presupuesto::class);
    }
}
