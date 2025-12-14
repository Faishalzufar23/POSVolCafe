<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable()
                    ->searchable(),

                // ImageColumn::make('photo')
                //     ->label('Foto')
                //     ->size(50)
                //     ->square()
                //     ->disk('public') // penting!
                //     ->url(fn ($record) => $record->photo
                //         ? asset('storage/' . $record->photo)
                //         : null
                //     ),



            ])
            ->defaultSort('name', 'asc')
            ->searchable()
            ->filters([
                //
            ]);
    }
}
