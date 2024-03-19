<?php

namespace App\Filament\Resources\PuertamaterialResource\Pages;

use App\Filament\Resources\PuertamaterialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPuertamaterials extends ListRecords
{
    protected static string $resource = PuertamaterialResource::class;
    protected static ?string $title =  "Material de puerta"; 
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
