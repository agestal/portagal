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
    protected $table = 'opciones';
    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
    }
}
