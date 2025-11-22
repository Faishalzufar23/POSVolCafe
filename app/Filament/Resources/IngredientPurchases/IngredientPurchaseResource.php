<?php

namespace App\Filament\Resources\IngredientPurchases;

use App\Filament\Resources\IngredientPurchases\Pages\CreateIngredientPurchase;
use App\Filament\Resources\IngredientPurchases\Pages\EditIngredientPurchase;
use App\Filament\Resources\IngredientPurchases\Pages\ListIngredientPurchases;
use App\Filament\Resources\IngredientPurchases\Schemas\IngredientPurchaseForm;
use App\Filament\Resources\IngredientPurchases\Tables\IngredientPurchasesTable;
use App\Models\IngredientPurchase;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IngredientPurchaseResource extends Resource
{
    protected static ?string $model = IngredientPurchase::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';
    protected static string|\UnitEnum|null $navigationGroup = 'Gudang';
    protected static ?string $navigationLabel = 'Laporan Masuk';
    protected static ?string $pluralLabel = 'Laporan Masuk';
    protected static ?string $modelLabel = 'Laporan Masuk';



    public static function form(Schema $schema): Schema
    {
        return IngredientPurchaseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IngredientPurchasesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $ingredient = \App\Models\Ingredient::find($data['ingredient_id']);

        if ($ingredient) {
            $ingredient->increment('stock', $data['quantity']);
        }

        return $data;
    }

    public static function getBreadcrumb(): string
    {
        return 'Laporan Masuk';
    }

    public static function getTitle(): string
    {
        return 'Laporan Masuk';
    }



    public static function getPages(): array
    {
        return [
            'index' => ListIngredientPurchases::route('/'),
            'create' => CreateIngredientPurchase::route('/create'),
            'edit' => EditIngredientPurchase::route('/{record}/edit'),
        ];
    }
}
