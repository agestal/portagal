<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Panel extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
    ];
    public function presupuestos()
    {
        return $this->belongsToMany(Presupuesto::class);
    }
    public function colorpanels() : HasMany
    {
        return $this->hasMany(Colorpanel::class);
    }
}
