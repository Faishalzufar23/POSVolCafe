<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        .title { text-align: center; font-weight: bold; font-size: 16px; }
        .center { text-align: center; }
        .divider { border-top: 1px dashed #999; margin: 10px 0; }
        table { width: 100%; }
        .right { text-align: right; }
    </style>
</head>
<body>

<div class="title">MyCoffee & Resto</div>
<div class="center">Jl. Contoh No.123, Surabaya</div>
<div class="center">Telp: 0812-3456-7890</div>

<div class="divider"></div>

<p><strong>Invoice:</strong> {{ $sale->invoice_number }}</p>
<p><strong>Tanggal:</strong> {{ $sale->created_at->format('d-m-Y') }}</p>
<p><strong>Jam:</strong> {{ $sale->created_at->format('H:i:s') }}</p>
<p><strong>Kasir:</strong> {{ $sale->user->name }}</p>

<div class="divider"></div>

<table>
    @foreach ($sale->items as $item)
        <tr>
            <td>{{ $item->product->name }} ({{ $item->quantity }}x)</td>
            <td class="right">Rp {{ number_format($item->line_total, 0, ',', '.') }}</td>
        </tr>
    @endforeach
</table>

<div class="divider"></div>

<p><strong>Total: Rp {{ number_format($sale->total, 0, ',', '.') }}</strong></p>

<div class="divider"></div>

<p class="center">WiFi: mycoffee-wifi | Pass: 12345678</p>
<p class="center">Terima kasih telah berbelanja 😊</p>

</body>
</html>
