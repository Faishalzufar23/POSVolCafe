<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;

class SalesChart extends ChartWidget
{
    // jangan static — parent pakai non-static
    protected ?string $heading = 'Grafik Penjualan 7 Hari Terakhir';

    protected function getData(): array
    {
        // labels 7 hari terakhir
        $labels = collect(range(6, 0))
            ->map(fn ($i) => now()->subDays($i)->format('d-m'));

        // totals sesuai tanggal masing-masing hari
        $totals = collect(range(6, 0))->map(fn ($i) =>
            Sale::whereDate('created_at', now()->subDays($i)->toDateString())->sum('total')
        );

        return [
            'labels' => $labels->toArray(),
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $totals->toArray(),
                    'borderColor' => '#4CAF50',
                    'backgroundColor' => 'rgba(76,175,80,0.25)',
                    'tension' => 0.3,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
