<?php

namespace App\Filament\Resources\FinanceReports\Pages;

use App\Filament\Resources\FinanceReports\FinanceReportResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use App\Models\Product;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;

class ListFinanceReports extends ListRecords
{
    protected static string $resource = FinanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Tombol export dengan filter tanggal
            Actions\Action::make('export_pdf')
                ->label('Export PDF')
                ->color('success')
                ->icon('heroicon-o-arrow-down-tray')
                ->form([
                    DatePicker::make('from')->label('Dari Tanggal')->required(),
                    DatePicker::make('until')->label('Sampai Tanggal')->required(),
                ])
                ->action(fn(array $data) => $this->exportPdf($data['from'], $data['until'])),
        ];
    }

    public function exportPdf($from, $until)
    {
        // Ambil semua produk + item penjualan yang sesuai tanggal
        $products = Product::with([
            'saleItems' => function ($q) use ($from, $until) {
                $q->whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $until);
            },
            'productIngredients.ingredient'
        ])->get();

        // Proses per produk
        $rows = $products->map(function ($p) {
            $qty = $p->saleItems->sum('quantity');
            $omzet = $p->saleItems->sum('line_total');
            $hpp_per_porsi = $p->hppPerPorsi();
            $total_hpp = $hpp_per_porsi * max($qty, 0); // mencegah null

            return [
                'name'            => $p->name,
                'harga_jual'      => $p->price,
                'hpp_per_porsi'   => $hpp_per_porsi,
                'qty'             => $qty,
                'total_penjualan' => $omzet,
                'total_hpp'       => $total_hpp,
                'laba_kotor'      => $omzet - $total_hpp,
            ];
        });

        // Hitung total pajak sesuai tanggal
        $total_tax = Sale::whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $until)
            ->sum('tax');

        // Summary
        $summary = [
            'total_penjualan' => $rows->sum('total_penjualan'),
            'total_hpp'       => $rows->sum('total_hpp'),
            'total_tax'       => $total_tax,
            'laba_kotor'      => $rows->sum('total_penjualan')
                - $total_tax
                - $rows->sum('total_hpp'),
        ];

        // Render PDF versi lengkap
        $pdf = PDF::loadView('pdf.finance-report', [
            'rows'    => $rows,
            'summary' => $summary,
            'from'    => $from,
            'until'   => $until,
            'tanggal' => now()->format('d M Y H:i'),
        ]);

        // Download
        return response()->streamDownload(
            fn() => print($pdf->output()),
            "laporan-keuangan-{$from}-sd-{$until}.pdf"
        );
    }

    public function getViewData(): array
    {
        // Ambil semua state filter aktif
        $filterState = $this->getTableFiltersForm()->getState();

        $from  = $filterState['created_at']['from'] ?? null;
        $until = $filterState['created_at']['until'] ?? null;

        return [
            'from' => $from,
            'until' => $until,
        ];
    }
}
