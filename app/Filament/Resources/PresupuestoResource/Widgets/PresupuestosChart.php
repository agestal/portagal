<?php

namespace App\Filament\Resources\PresupuestoResource\Widgets;

use App\Filament\Resources\PresupuestoResource\Widgets\TrendValue;
use Filament\Widgets\ChartWidget;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use DB;
use Filament\Support\RawJs;

class PresupuestosChart extends ApexChartWidget
{
    protected static ?string $chartId = 'PresupuestosChart';

    protected static ?string $heading = 'Gráfico de Mediciones';

    protected function getOptions(): array
    {
        $data = DB::table('presupuestos AS p')
                    ->join('materials AS m','p.material_id','m.id')
                    ->select('m.nombre AS material',DB::raw('count(*) as presupuestos'))
                    ->groupBy('m.nombre')
                    ->get();
        $values = [];
        $labels = [];
        foreach ( $data as $d )
        {
            array_push($values,$d->presupuestos);
            array_push($labels,$d->material);
        }
        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'BlogPostsChart',
                    'data' => $values,
                ],
            ],
            'xaxis' => [
                'categories' => $labels,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
        ];
    }

}
