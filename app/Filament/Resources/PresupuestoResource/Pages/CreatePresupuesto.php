<?php

namespace App\Filament\Resources\PresupuestoResource\Pages;

use App\Filament\Resources\PresupuestoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePresupuesto extends CreateRecord
{
    protected static string $resource = PresupuestoResource::class;
    protected static ?string $modeLabel = "Medicion";
    protected static ?string $label = "Medicion";
    protected static ?string $pluralModelLabel = "Mediciones";
    protected static ?string $navigationLabel = "Mediciones";
    protected static ?string $title = "Nueva Medición";
    public $drawingData;
}
