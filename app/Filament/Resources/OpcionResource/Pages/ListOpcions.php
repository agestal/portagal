<?php

namespace App\Filament\Resources\OpcionResource\Pages;

use App\Filament\Resources\OpcionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOpcions extends ListRecords
{
    protected static string $resource = OpcionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
