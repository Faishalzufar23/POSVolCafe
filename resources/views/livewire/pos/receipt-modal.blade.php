@if ($showReceipt && $receiptData)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-5 w-[360px]">

            {{-- HEADER --}}
            <div class="text-center mb-3">
                <h2 class="text-lg font-bold">MyCoffee & Resto</h2>
                <p class="text-sm text-gray-500">Jl. Contoh No. 123, Surabaya</p>
                <p class="text-sm text-gray-500">Telp: 0812-3456-7890</p>
            </div>

            <hr class="my-2">

            {{-- INFO TRANSAKSI --}}
            <p><strong>Invoice:</strong> {{ $receiptData->invoice_number }}</p>
            <p><strong>Tanggal:</strong> {{ $receiptData->created_at->format('d-m-Y') }}</p>
            <p><strong>Jam:</strong> {{ $receiptData->created_at->format('H:i:s') }}</p>
            <p><strong>Kasir:</strong> {{ $receiptData->user->name }}</p>

            <hr class="my-3">

            {{-- LIST ITEM --}}
            @foreach ($receiptData->items as $item)
                <div class="flex justify-between text-sm mb-1">
                    <span>{{ $item->product->name }} ({{ $item->quantity }}x)</span>
                    <span>Rp {{ number_format($item->line_total, 0, ',', '.') }}</span>
                </div>
            @endforeach

            <hr class="my-3">

            {{-- TOTAL --}}
            <div class="text-lg font-bold">
                Total: Rp {{ number_format($receiptData->total, 0, ',', '.') }}
            </div>

            {{-- FOOTER / WIFI --}}
            <div class="mt-4 text-center text-xs text-gray-600">
                <p>WiFi: mycoffee-wifi | Pass: 12345678</p>
            </div>

            {{-- BUTTON KIRIM WHATSAPP --}}
            @php
                // ambil nomor dari customer model ATAU dari kolom sale.customer_phone
                $rawPhone = $receiptData->customer->phone ?? ($receiptData->customer_phone ?? null);
            @endphp

            @if ($rawPhone)
                @php
                    // normalisasi nomor
                    $waNumber = preg_replace('/[^0-9]/', '', $rawPhone);

                    if (str_starts_with($waNumber, '0')) {
                        $waNumber = '62' . substr($waNumber, 1);
                    }

                    // format pesan
                    $msg = 'Struk Pembayaran%0A';
                    $msg .= "Invoice: {$receiptData->invoice_number}%0A";
                    $msg .= 'Tanggal: ' . $receiptData->created_at->format('d-m-Y H:i:s') . '%0A';
                    $msg .= "Kasir: {$receiptData->user->name}%0A%0A";

                    foreach ($receiptData->items as $it) {
                        $msg .=
                            "{$it->product->name} ({$it->quantity}x) - Rp " .
                            number_format($it->line_total, 0, ',', '.') .
                            '%0A';
                    }

                    $msg .= '%0ATotal: Rp ' . number_format($receiptData->total, 0, ',', '.');
                    $msg .= '%0A=====================%0A';
                    $msg .= 'Terima kasih telah berbelanja!';
                @endphp

                <a href="https://wa.me/{{ $waNumber }}?text={{ $msg }}" target="_blank"
                    class="block w-full bg-green-600 text-white font-semibold text-center py-2 rounded shadow mb-3">
                    📩 Kirim Struk via WhatsApp
                </a>
            @endif

            @if ($receiptPdfUrl)
                <a href="{{ $receiptPdfUrl }}" target="_blank"
                    class="block bg-blue-600 text-white text-center py-2 rounded mb-3">
                    📄 Download Struk (PDF)
                </a>
            @endif


            {{-- BUTTON TUTUP --}}
            <button wire:click="$set('showReceipt', false)" class="w-full bg-gray-300 rounded py-2">
                Tutup
            </button>

        </div>
    </div>
@endif
