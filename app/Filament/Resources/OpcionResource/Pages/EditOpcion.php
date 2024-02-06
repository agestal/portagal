<?php

namespace App\Filament\Resources\OpcionResource\Pages;

use App\Filament\Resources\OpcionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOpcion extends EditRecord
{
    protected static string $resource = OpcionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
