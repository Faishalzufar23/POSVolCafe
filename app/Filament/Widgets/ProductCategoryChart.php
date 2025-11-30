<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\SaleItem;

class ProductCategoryChart extends ChartWidget
{
    protected ?string $heading = 'Revenue by Product';

    protected function getData(): array
    {
        $items = SaleItem::selectRaw('name, SUM(line_total) as total')
            ->groupBy('name')
            ->get();

        return [
            'datasets' => [
                [
                    'data' => $items->pluck('total')->toArray(),
                    'backgroundColor' => [
                        '#FFB74D', // Orange soft
                        '#4FC3F7', // Light blue
                        '#81C784', // Soft green
                        '#BA68C8', // Purple pastel
                        '#E57373', // Soft red
                        '#FFD54F', // Soft yellow
                    ],
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $items->pluck('name')->toArray(),
        ];
    }

    // Atur tipe chart
    protected function getType(): string
    {
        return 'doughnut';
    }

    // Tinggi chart yang benar (Filament 3/4 bawaan)
    protected function getMaxHeight(): ?string
    {
        return '300px';
    }

    // Atur column span TIDAK boleh static di ChartWidget
    public function getColumnSpan(): array|int|string
    {
        return 1;//ukurannya lebih kecil
    }
}
