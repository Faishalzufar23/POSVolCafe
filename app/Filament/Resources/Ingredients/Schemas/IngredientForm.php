<?php

namespace App\Filament\Resources\Ingredients\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Models\IngredientPurchase;

class IngredientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            TextInput::make('name')
                ->label('Nama Bahan')
                ->required(),

            Select::make('unit')
                ->label('Satuan')
                ->options([
                    'gram' => 'Gram',
                    'ml' => 'mL',
                    'pcs' => 'Pcs',
                ])
                ->required(),

            TextInput::make('stock')
                ->label('Stok Sekarang')
                ->numeric()
                ->disabled()
                ->default(fn($record) => $record?->stock ?? 0),

            TextInput::make('add_stock')
                ->label('Tambah Stok')
                ->numeric()
                ->default(0)
                ->reactive()
                ->afterStateUpdated(function ($state, $record) {
                    if (!$record || $state <= 0) return;

                    // update stok langsung
                    $record->increment('stock', $state);

                    // catat riwayat masuk stok
                    IngredientPurchase::create([
                        'ingredient_id' => $record->id,
                        'quantity' => $state,
                        'unit' => $record->unit,
                        'purchase_date' => now(),
                    ]);
                }),

        ]);
    }
}

