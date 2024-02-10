<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function colorpanels()
    {
        return $this->belongsToMany(Color::class, 'colorpanel_panel', 'panel_id', 'color_id');
    }
}
