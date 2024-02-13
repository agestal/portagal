<?php

namespace App\Filament\Resources\FuncionamientoResource\Pages;

use App\Filament\Resources\FuncionamientoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFuncionamientos extends ListRecords
{
    protected static string $resource = FuncionamientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
