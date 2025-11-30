<?php

namespace App\Filament\Resources\FinanceReports\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Product;

class FinanceReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(Product::query())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Produk'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Harga Jual')
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('hpp')
                    ->label('HPP per Porsi')
                    ->state(fn (Product $p) => $p->hppPerPorsi())
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('sold')
                    ->label('Jumlah Terjual')
                    ->state(fn (Product $p) => $p->saleItems->sum('quantity')),

                Tables\Columns\TextColumn::make('total_sales')
                    ->label('Total Penjualan')
                    ->state(fn (Product $p) => $p->saleItems->sum('line_total'))
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('total_hpp')
                    ->label('Total HPP')
                    ->state(fn (Product $p) => $p->hppPerPorsi() * $p->saleItems->sum('quantity'))
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('profit')
                    ->label('Laba Kotor')
                    ->state(fn (Product $p) =>
                        $p->saleItems->sum('line_total') -
                        ($p->hppPerPorsi() * $p->saleItems->sum('quantity'))
                    )
                    ->money('IDR'),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }
}
