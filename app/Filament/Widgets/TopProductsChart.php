<?php

namespace App\Filament\Widgets;

use App\Models\SaleItem;
use Filament\Widgets\ChartWidget;

class TopProductsChart extends ChartWidget
{
    protected ?string $heading = 'Produk Terlaris';

    protected function getData(): array
    {
        $data = SaleItem::selectRaw('name, SUM(quantity) as total')
            ->groupBy('name')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return [
            'labels' => $data->pluck('name'),
            'datasets' => [
                [
                    'label' => 'Jumlah Terjual',
                    'data' => $data->pluck('total'),
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
