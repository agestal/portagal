<?php

namespace App\Filament\Resources\FuncionamientoResource\Pages;

use App\Filament\Resources\FuncionamientoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFuncionamiento extends EditRecord
{
    protected static string $resource = FuncionamientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
