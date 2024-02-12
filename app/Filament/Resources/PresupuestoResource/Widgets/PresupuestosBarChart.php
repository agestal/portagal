<?php

namespace App\Filament\Resources\PresupuestoResource\Widgets;
use DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class PresupuestosBarChart extends ApexChartWidget
{
    protected static ?string $chartId = 'PresupuestosChart';

    protected static ?string $heading = 'PresupuestosChart';

    protected function getOptions(): array
    {
        $data = DB::table('presupuestos AS p')
                    ->join('puertas AS pr','p.puerta_id','pr.id')
                    ->select('pr.nombre AS puerta',DB::raw('count(*) as presupuestos'))
                    ->groupBy('pr.nombre')
                    ->get();
        $values = [];
        $labels = [];
        foreach ( $data as $d )
        {
            array_push($values,$d->presupuestos);
            array_push($labels,$d->puerta);
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
