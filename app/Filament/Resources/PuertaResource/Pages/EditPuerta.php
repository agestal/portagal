<?php

namespace App\Filament\Resources\PuertaResource\Pages;

use App\Filament\Resources\PuertaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPuerta extends EditRecord
{
    protected static string $resource = PuertaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
