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
        'panel_id',
        'colorpanel_id',
        'puerta_id',
        'nombre_cliente',
        'pedido',
        'email',
        'archivo1',
        'firma'
    ];
    public function puertas()
    {
        return $this->belongsTo(Puerta::class, 'puerta_id' , 'id');
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
                Material::class => 'id',
                Color::class => 'id'
            ]
        );
    }
    public function panels()
    {
        return $this->belongsTo(Panel::class, 'panel_id', 'id');
    }
    public function colorpanels() 
    {
        return $this->belongsTo(Colorpanel::class, 'colorpanel_id', 'id');
    }
}
