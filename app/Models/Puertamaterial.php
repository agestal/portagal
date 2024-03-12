<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puertamaterial extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre'
    ];
    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
    }
}
