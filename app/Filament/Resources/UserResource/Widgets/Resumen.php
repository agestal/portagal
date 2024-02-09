<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use DB;

class Resumen extends BaseWidget
{
    protected function getStats(): array
    {
        $puertas = DB::table('puertas')->count();
        $materiales = DB::table('materials')->count();

        $presupuestos = DB::table('presupuestos')->count();

        return [
            Stat::make('Puertas creadas:', $puertas),
            Stat::make('Materiales disponibles:', $materiales),
            Stat::make('Presupuestos generados:', $presupuestos)->description('Presupuestos generados desde el inicio de los tiempos')->icon('heroicon-o-document'),
        ];
    }
}
