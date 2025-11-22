<?php

namespace App\Filament\Resources\FinanceReports\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class FinanceReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(\App\Models\Product::query())
            ->columns([
                TextColumn::make('name')
                    ->label('Produk Minuman'),

                TextColumn::make('price')
                    ->label('Harga Jual Perporsi')
                    ->money('IDR', true),

                // TextColumn::make('hpp')
                //     ->label('Biaya Bahan Baku Perporsi')
                //     ->getStateUsing(fn($record) => $record->cost())
                //     ->money('IDR', true),

                TextColumn::make('profit')
                    ->label('Laba Perporsi')
                    ->money('IDR', true)
                    ->getStateUsing(fn($record) => $record->price - $record->cost()),

                TextColumn::make('sold')
                    ->label('Jumlah Terjual (Harian)')
                    ->getStateUsing(fn($record) => $record->soldToday()),

                TextColumn::make('total_profit')
                    ->label('Laba Total')
                    ->money('IDR', true)
                    ->getStateUsing(
                        fn($record) => ($record->price - $record->cost()) * $record->soldToday()
                    ),
            ]);
    }
}
