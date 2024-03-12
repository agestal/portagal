<?php

namespace App\Filament\Resources\TipoMotorResource\Pages;

use App\Filament\Resources\TipoMotorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipoMotor extends EditRecord
{
    protected static string $resource = TipoMotorResource::class;
    protected static ?string $title =  "Tipo de motor"; 

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
