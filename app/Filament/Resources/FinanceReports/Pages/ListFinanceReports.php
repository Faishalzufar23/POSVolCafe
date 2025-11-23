<?php

namespace App\Filament\Resources\FinanceReports\Pages;

use App\Filament\Resources\FinanceReports\FinanceReportResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ListFinanceReports extends ListRecords
{
    protected static string $resource = FinanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_pdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document')
                ->color('danger')
                ->action(function () {
                    $pdf = Pdf::loadView('exports.finance-report', [
                        'records' => \App\Models\Product::all(),
                    ]);

                    return response()->streamDownload(
                        fn() => print($pdf->output()),
                        'finance-report.pdf'
                    );
                }),
        ];
    }
}
