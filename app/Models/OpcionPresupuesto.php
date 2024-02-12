<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
class OpcionPresupuesto extends Model
{
    use HasFactory;
    protected $table = 'opcion_presupuesto';
    protected $fillable = [
        'opcion_id',
        'presupuesto_id',
        'valor'
    ];
    public function presupuesto(): BelongsTo
    {
        return $this->belongsTo(Presupuesto::class);
    }
    
    public function opcion(): BelongsTo
    {
        return $this->belongsTo(Opcion::class);
    }
}
