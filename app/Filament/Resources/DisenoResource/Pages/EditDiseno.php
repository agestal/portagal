<?php

namespace App\Filament\Resources\DisenoResource\Pages;

use App\Filament\Resources\DisenoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiseno extends EditRecord
{
    protected static string $resource = DisenoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
