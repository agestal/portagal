<?php

namespace App\Filament\Resources\PuertamaterialResource\Pages;

use App\Filament\Resources\PuertamaterialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPuertamaterial extends EditRecord
{
    protected static string $resource = PuertamaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
