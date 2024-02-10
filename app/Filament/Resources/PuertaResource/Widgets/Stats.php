<?php

namespace App\Filament\Resources\PuertaResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Puerta;

class Stats extends BaseWidget
{
    protected static ?int $sort = -2;
    protected function getStats(): array
    {
        return [
            Stat::make('Puertas creadas', Puerta::count()),
        ];
    }
}
