<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesStats extends BaseWidget
{
    protected function getStats(): array
    {
        $todaySales = Sale::whereDate('created_at', today())->sum('total');
        $monthSales = Sale::whereMonth('created_at', now()->month)->sum('total');
        $transactions = Sale::count();

        return [
            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($todaySales, 0, ',', '.'))
                ->description('Total penjualan hari ini')
                ->color('success'),

            Stat::make('Pendapatan Bulanan', 'Rp ' . number_format($monthSales, 0, ',', '.'))
                ->description('Total penjualan bulan ini')
                ->color('primary'),

            Stat::make('Total Transaksi', number_format($transactions))
                ->description('Total transaksi keseluruhan')
                ->color('warning'),
        ];
    }
}
