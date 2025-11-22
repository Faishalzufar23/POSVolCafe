<?php

namespace App\Filament\Resources\IngredientPurchases\Pages;

use App\Filament\Resources\IngredientPurchases\IngredientPurchaseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIngredientPurchase extends EditRecord
{
    protected static string $resource = IngredientPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
