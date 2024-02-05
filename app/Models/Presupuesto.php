<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Znck\Eloquent\Relations\BelongsToThrough;

class Presupuesto extends Model
{
    use HasFactory;
    protected $fillable = [
        'material_id',
        'color_id',
        'puerta_id'
    ];
    public function puertas()
    {
        return $this->hasMany(Puerta::class);
    }
    use \Znck\Eloquent\Traits\BelongsToThrough;
    public function materials()
    {
        return $this->hasMany(Material::class);
    }
    public function colors() : BelongsToThrough
    {
        return $this->belongsToThrough(
            Material::class,
            [ColorMaterial::class, Color::class],
            foreignKeyLookup: [ 
                ColorMaterial::class => 'id'
            ],
            localKeyLookup: [ 
                ColorMaterial::class => 'color_id',
            ]
        );
    }
}
