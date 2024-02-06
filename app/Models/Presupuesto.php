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
        'fecha',
        'material_id',
        'color_id',
        'puerta_id',
        'pano_id',
        'diseno_id',
        'apertura_id',
        'opcion_id'
    ];
    public function puertas()
    {
        return $this->belongsTo(Puerta::class, 'puerta_id' , 'id');
    }
    public function aperturas()
    {
        return $this->belongsTo(Apertura::class, 'apertura_id', 'id');
    }
    public function panos()
    {
        return $this->belongsTo(Pano::class, 'apertura_id', 'id');
    }
    public function disenos()
    {
        return $this->belongsTo(Diseno::class, 'apertura_id', 'id');
    }
    use \Znck\Eloquent\Traits\BelongsToThrough;
    public function materials()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }
    public function colors() : BelongsToThrough
    {
        return $this->belongsToThrough(
            Color::class,
            [ColorMaterial::class, Material::class],
            foreignKeyLookup: [ 
                ColorMaterial::class => 'id',
                Material::class => 'material_id'
            ],
            localKeyLookup: [ 
                Color::class => 'id'
            ]
        );
    }
}
