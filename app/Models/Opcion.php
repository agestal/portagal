<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre'
    ];
    public function presupuestos()
    {
        return $this->belongsToMany(Presupuesto::class);
    }
}
