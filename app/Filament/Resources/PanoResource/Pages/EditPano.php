<?php

namespace App\Filament\Resources\PanoResource\Pages;

use App\Filament\Resources\PanoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPano extends EditRecord
{
    protected static string $resource = PanoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
