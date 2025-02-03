<?php

namespace App\Filament\Resources\PresupuestoResource\Pages;

use App\Filament\Resources\PresupuestoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPresupuestos extends ListRecords
{
    protected static string $resource = PresupuestoResource::class;
    protected static ?string $modeLabel = "Medicion";
    protected static ?string $pluralModelLabel = "Mediciones";
    protected static ?string $navigationLabel = "Mediciones";

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            PresupuestoResource\Widgets\PresupuestosBarChart::class,
        ];
    }
}
