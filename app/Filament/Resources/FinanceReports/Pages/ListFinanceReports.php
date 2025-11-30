<?php

namespace App\Filament\Resources\FinanceReports\Pages;

use App\Filament\Resources\FinanceReports\FinanceReportResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

class ListFinanceReports extends ListRecords
{
    protected static string $resource = FinanceReportResource::class;

    /**
     * Header actions di atas tabel
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export_pdf')
                ->label('Export PDF')
                ->color('success')
                ->icon('heroicon-o-arrow-down-tray')
                ->action('exportPdf'),
        ];
    }

    /**
     * Generate & Download PDF
     */
    public function exportPdf()
    {
        // Ambil data produk + relasi bahan baku & items terjual
        $products = Product::with(['saleItems', 'productIngredients.ingredient'])->get();

        // Hitung tabel laporan untuk masing-masing produk
        $rows = $products->map(function ($p) {

            $qty = $p->saleItems->sum('quantity'); // jumlah terjual
            $total_penjualan = $p->saleItems->sum('line_total'); // omzet
            $hpp_per_porsi = $p->hppPerPorsi(); // sudah ada di model
            $total_hpp = $hpp_per_porsi * $qty;
            $laba_kotor = $total_penjualan - $total_hpp;

            return [
                'name'            => $p->name,
                'harga_jual'      => $p->price,
                'hpp_per_porsi'   => $hpp_per_porsi,
                'qty'             => $qty,
                'total_penjualan' => $total_penjualan,
                'total_hpp'       => $total_hpp,
                'laba_kotor'      => $laba_kotor,
            ];
        });

        // Hitung ringkasan total
        $summary = [
            'total_penjualan' => $rows->sum('total_penjualan'),
            'total_hpp'       => $rows->sum('total_hpp'),
            'laba_kotor'      => $rows->sum('laba_kotor'),
        ];

        // Render PDF
        $pdf = PDF::loadView('pdf.finance-report', [
            'rows'     => $rows,
            'summary'  => $summary,
            'tanggal'  => now()->format('d M Y'),
        ]);

        // Download file PDF
        return response()->streamDownload(
            fn () => print($pdf->output()),
            'laporan-keuangan-' . now()->format('Ymd_His') . '.pdf'
        );
    }
}
