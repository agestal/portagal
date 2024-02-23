<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FuncionamientoPresupuesto extends Model
{
    use HasFactory;
    protected $table = 'funcionamiento_presupuesto';
    protected $fillable = [
        'funcionamiento_id',
        'presupuesto_id',
        'valor'
    ];
    public function presupuesto(): BelongsTo
    {
        return $this->belongsTo(Presupuesto::class);
    }
    
    public function funcionamiento(): BelongsTo
    {
        return $this->belongsTo(Funcionamiento::class);
    }
}
