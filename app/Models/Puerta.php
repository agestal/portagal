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
    public function presupuesto()
    {
        return $this->belongsToMany(Presupuesto::class);
    }
    public function material()
    {
        return $this->belongsToMany(Material::class);
    }
}
