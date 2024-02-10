<?php

namespace App\Filament\Resources\ColorpanelResource\Pages;

use App\Filament\Resources\ColorpanelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListColorpanels extends ListRecords
{
    protected static string $resource = ColorpanelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
