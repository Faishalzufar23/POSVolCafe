<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Sale;

class SalesByMonth extends ChartWidget
{
    protected ?string $heading = 'Monthly Sales';

    protected function getData(): array
    {
        $sales = Sale::selectRaw('MONTH(created_at) as m, SUM(total) as total')
            ->groupBy('m')
            ->orderBy('m')
            ->pluck('total','m');

        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => array_values($sales->toArray()),
                ],
            ],
            'labels' => array_map(fn($m) => date('F', mktime(0,0,0,$m,1)), array_keys($sales->toArray())),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
