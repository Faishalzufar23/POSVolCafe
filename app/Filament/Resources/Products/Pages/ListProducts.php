<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        if (auth()->user()->role !== 'admin') {
            return []; // kasir tidak melihat tombol create
        }
        return [
            CreateAction::make(),
        ];
    }
}
