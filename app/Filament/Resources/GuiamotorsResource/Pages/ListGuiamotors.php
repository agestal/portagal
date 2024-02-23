<?php

namespace App\Filament\Resources\GuiamotorsResource\Pages;

use App\Filament\Resources\GuiamotorsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGuiamotors extends ListRecords
{
    protected static string $resource = GuiamotorsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
