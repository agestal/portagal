<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Colorpanel extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
    ];
    public function panels() : BelongsTo
    {
        return $this->belongsTo(Panel::class);
    }
    public function presupuestos() : BelongsToMany
    {
        return $this->belongsToMany(Presupuesto::class);
    }
}
