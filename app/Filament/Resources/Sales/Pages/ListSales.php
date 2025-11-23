<?php

namespace App\Filament\Resources\Sales\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ListRecords;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\Sales\SaleResource;
use Filament\Infolists\Components\RepeatableEntry;


class ListSales extends ListRecords
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('detail')
                ->label('Lihat Detail')
                ->icon('heroicon-o-eye')
                ->modalHeading('Detail Pesanan')
                ->modalWidth('lg')
                ->modalContent(function (Model $record) {
                    return view('modals.sale-detail-modal', [
                        'order' => $record->load('items.product'),
                    ]);
                }),
        ];
    }
}
