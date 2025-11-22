<?php

namespace App\Filament\Resources\IngredientPurchases\Pages;

use App\Filament\Resources\IngredientPurchases\IngredientPurchaseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIngredientPurchases extends ListRecords
{
    protected static string $resource = IngredientPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
