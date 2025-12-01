<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\TopCashiers;
use App\Filament\Widgets\SalesByMonth;
use App\Filament\Widgets\LowStockItems;
use App\Filament\Widgets\SalesTrendChart;
use App\Filament\Widgets\BestSellerRanking;
use App\Filament\Widgets\SalesOverviewStats;
use App\Filament\Widgets\ProductCategoryChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            SalesOverviewStats::class,
            SalesByMonth::class,
            ProductCategoryChart::class,
            SalesTrendChart::class,
        ];
    }

}
