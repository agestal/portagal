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
        $opciones = DB::table('opcions')->count();
        $presupuestos = DB::table('presupuestos')->count();

        return [
            Stat::make('Puertas creadas:', $puertas),
            Stat::make('Opciones disponibles:', $opciones),
            Stat::make('Mediciones generadas:', $presupuestos)->description('Mediciones generadas desde el inicio de los tiempos')->icon('heroicon-o-document'),
        ];
    }
}
