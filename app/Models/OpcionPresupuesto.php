<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpcionPresupuesto extends Model
{
    use HasFactory;
    protected $table = 'opcion_presupuesto';
    protected $fillable = [
        'opcion_id',
        'presupuesto_id',
        'valor'
    ];
    public function presupuestos()
    {
        return $this->belongsToMay(Presupuesto::class);
    }
}
