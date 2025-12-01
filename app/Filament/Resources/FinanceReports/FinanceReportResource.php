<?php

namespace App\Filament\Resources\FinanceReports;

use App\Filament\Resources\FinanceReports\Pages\ListFinanceReports;
use App\Filament\Resources\FinanceReports\Schemas\FinanceReportForm;
use App\Filament\Resources\FinanceReports\Schemas\FinanceReportInfolist;
use App\Filament\Resources\FinanceReports\Tables\FinanceReportsTable;
use App\Models\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FinanceReportResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Laporan Keuangan';
    protected static ?string $pluralLabel = 'Laporan Keuangan';
    protected static ?string $modelLabel = 'Laporan Keuangan';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return FinanceReportForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FinanceReportInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FinanceReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    /**
     * ❗ HANYA ADMIN YANG BOLEH AKSES HALAMAN LAPORAN KEUANGAN
     */
    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin();
    }

    /**
     * ❗ HANYA ADMIN YANG BOLEH MELIHAT MENU DI SIDEBAR
     */
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->isAdmin();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFinanceReports::route('/'),
        ];
    }
}
