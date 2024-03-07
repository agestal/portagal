<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Colorpanel extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
    ];
    /*public function panels()
    {
        return $this->belongsToMany(Panel::class, 'colorpanel_panel', 'panel_id', 'colorpanel_id');
    }*/
    public function presupuestos() : BelongsToMany
    {
        return $this->belongsToMany(Presupuesto::class);
    }
}
