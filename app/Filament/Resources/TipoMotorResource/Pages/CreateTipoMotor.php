<?php

namespace App\Filament\Resources\TipoMotorResource\Pages;

use App\Filament\Resources\TipoMotorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTipoMotor extends CreateRecord
{
    protected static string $resource = TipoMotorResource::class;
    protected static ?string $title =  "Tipo de motor"; 
}
