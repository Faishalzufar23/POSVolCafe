<style>
    .detail-modal {
        font-size: 14px;
        padding: 6px 0;
    }
    .detail-header {
        margin-bottom: 12px;
        font-weight: 600;
    }
    .modal-table {
        width: 100%;
        margin-bottom: 16px;
        border-collapse: collapse;
    }
    .modal-table td {
        padding: 4px 0;
    }
    .text-right {
        text-align: right;
    }
    .text-bold {
        font-weight: 600;
    }
    .divider {
        border-bottom: 1px solid #ddd;
        margin: 8px 0;
    }
</style>

<div style="padding: 20px; font-size: 15px; line-height: 1.5;">
    <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 16px;">
        Detail Pesanan - {{ $order->invoice_number }}
    </h2>

    <div style="margin-bottom: 8px;">
        <strong>Kasir:</strong> {{ $order->user->name }}
    </div>
    <div style="margin-bottom: 16px;">
        <strong>Tanggal:</strong> {{ $order->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}
    </div>

    @foreach($order->items as $item)
        <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
            <div>
                {{ $item->product->name }}
                <span style="color:#555;">{{ $item->quantity }} x {{ 'IDR ' . number_format($item->price,0,',','.') }}</span>
            </div>
            <div style="font-weight: bold;">
                {{ 'IDR ' . number_format($item->price * $item->quantity,0,',','.') }}
            </div>
        </div>
    @endforeach

    <hr style="margin:16px 0;">

    <div style="margin-bottom:6px;">
        <strong>Metode Pembayaran:</strong> {{ strtoupper($order->payment_method) }}
    </div>

    <div style="margin-bottom:6px;">
        <strong>Dibayar:</strong> {{ 'IDR ' . number_format($order->paid_amount,0,',','.') }}
    </div>

    @if(strtolower($order->payment_method) == 'cash')
        <div style="margin-bottom:6px;">
            <strong>Kembalian:</strong> {{ 'IDR ' . number_format($order->change_amount,0,',','.') }}
        </div>
    @endif

    <div style="margin-top:10px; font-weight:bold; font-size:16px;">
        Total Pembayaran : {{ 'IDR ' . number_format($order->total,0,',','.') }}
    </div>

    <div style="text-align:center; margin-top:20px;">
    </div>
</div>

