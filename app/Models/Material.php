<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre'
    ];
    public function presupuestos()
    {
        return $this->belongsToMany(Presupuesto::class);
    }
    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }
}
