<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'tipo_id'
    ];
    public function tipomotors()
    {
        return $this->hasOne(TipoMotor::class);
    }
}
