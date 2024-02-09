<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colorpanel extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'std'
    ];
    public function panels()
    {
        return $this->belongsToMany(Panel::class, 'colorpanel_panel', 'panel_id', 'color_id');
    }
}
