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
    public function colorpanels() : BelongsToThrough
    {
        return $this->belongsToThrough(
            Colorpanel::class,
            [ColorpanelPanel::class, Panel::class],
            foreignKeyLookup: [ 
                ColorpanelPanel::class => 'id',
                Panel::class => 'panel_id'
            ],
            localKeyLookup: [ 
                Panel::class => 'id',
                Colorpanel::class => 'id'
            ]
        );
    }
}
