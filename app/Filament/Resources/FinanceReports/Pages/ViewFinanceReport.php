<?php

namespace App\Filament\Resources\FinanceReports\Pages;

use App\Filament\Resources\FinanceReports\FinanceReportResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFinanceReport extends ViewRecord
{
    protected static string $resource = FinanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
