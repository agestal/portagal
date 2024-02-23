<?php

namespace App\Filament\Resources\GuiamotorsResource\Pages;

use App\Filament\Resources\GuiamotorsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuiamotors extends EditRecord
{
    protected static string $resource = GuiamotorsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
