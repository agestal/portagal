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
    public function material()
    {
        return $this->belongsToMany(Materiales::class);
    }
}
