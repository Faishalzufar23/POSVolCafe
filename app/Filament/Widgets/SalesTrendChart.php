<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Sale;
use Illuminate\Support\Carbon;

class SalesTrendChart extends ChartWidget
{
    // NOTE: parent defines $heading as non-static in your Filament version
    protected ?string $heading = 'Sales Trend (Last 30 Days)';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        // ambil per-hari selama 30 hari terakhir
        $from = now()->subDays(30)->startOfDay();
        $rows = Sale::selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->where('created_at', '>=', $from)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // buat label untuk 30 hari agar chart selalu konsisten (jika hari kosong -> 0)
        $labels = [];
        $values = [];
        for ($d = 0; $d < 30; $d++) {
            $date = Carbon::today()->subDays(29 - $d)->toDateString();
            $labels[] = date('M d', strtotime($date));
            $values[] = isset($rows[$date]) ? (float) $rows[$date]->total : 0.0;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => $values,
                ],
            ],
        ];
    }
}
