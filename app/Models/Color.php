<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre'
    ];
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'color_material', 'material_id', 'color_id');
    }
}
