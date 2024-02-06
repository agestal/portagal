<?php

namespace App\Filament\Resources\AperturaResource\Pages;

use App\Filament\Resources\AperturaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAperturas extends ListRecords
{
    protected static string $resource = AperturaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
