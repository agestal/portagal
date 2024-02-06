<?php

namespace App\Filament\Resources\PanoResource\Pages;

use App\Filament\Resources\PanoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPanos extends ListRecords
{
    protected static string $resource = PanoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
