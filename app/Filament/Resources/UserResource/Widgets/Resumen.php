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
        $disenos = DB::table('disenos')->count();
        $panos = DB::table('panos')->count();
        $presupuestos = DB::table('presupuestos')->count();
        $opciones = DB::table('opciones')->count();
        return [
            Stat::make('Puertas creadas:', $puertas),
            Stat::make('Materiales disponibles:', $materiales),
            Stat::make('Diseños disponibles:', $disenos),
            Stat::make('Paños configurables:', $panos),
            Stat::make('Presupuestos generados:', $presupuestos)->description('Presupuestos generados desde el inicio de los tiempos')->icon('heroicon-o-document'),
            Stat::make('Opciones adicionales disponibles:',$opciones)
        ];
    }
}
