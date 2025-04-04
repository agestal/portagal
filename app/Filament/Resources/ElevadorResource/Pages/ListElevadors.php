<?php

namespace App\Filament\Resources\ElevadorResource\Pages;

use App\Filament\Resources\ElevadorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListElevadors extends ListRecords
{
    protected static string $resource = ElevadorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
