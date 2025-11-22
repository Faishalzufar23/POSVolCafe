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
            Action::make('export_excel')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $records = \App\Models\Product::all();

                    return \Excel::create('finance-report', function ($excel) use ($records) {
                        $excel->sheet('Sheet 1', function ($sheet) use ($records) {
                            $sheet->loadView('exports.finance-report', [
                                'records' => $records,
                            ]);
                        });
                    })->download('xlsx');
                }),


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
