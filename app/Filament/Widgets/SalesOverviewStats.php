<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Sale;

class SalesOverviewStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Sales', 'Rp ' . number_format(Sale::sum('total'))),
            Stat::make('Transactions', Sale::count()),
            Stat::make('Today', 'Rp ' . number_format(Sale::whereDate('created_at', today())->sum('total'))),
        ];
    }
}
