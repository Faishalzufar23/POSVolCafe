<?php

namespace App\Filament\Resources\FinanceReports\Pages;

use App\Filament\Resources\FinanceReports\FinanceReportResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFinanceReport extends EditRecord
{
    protected static string $resource = FinanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
