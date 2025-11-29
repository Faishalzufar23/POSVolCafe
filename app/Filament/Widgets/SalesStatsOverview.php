<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use App\Models\SaleItem;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $today = Sale::whereDate('created_at', today());
        $month = Sale::whereMonth('created_at', now()->month);

        $topProduct = SaleItem::selectRaw('name, SUM(quantity) as total')
            ->groupBy('name')
            ->orderByDesc('total')
            ->first();

        return [
            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($today->sum('total'), 0, ',', '.'))
                ->description('Total pendapatan hari ini')
                ->color('success')
                ->icon('heroicon-o-banknotes'),

            Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format($month->sum('total'), 0, ',', '.'))
                ->description('Semua transaksi bulan ini')
                ->color('primary')
                ->icon('heroicon-o-chart-bar'),

            Stat::make('Transaksi Hari Ini', $today->count())
                ->description('Jumlah transaksi masuk hari ini')
                ->color('warning')
                ->icon('heroicon-o-shopping-bag'),

            Stat::make('Produk Terlaris', $topProduct?->name ?? '-')
                ->description(($topProduct->total ?? 0) . ' terjual')
                ->color('info')
                ->icon('heroicon-o-fire'),
        ];
    }
}
