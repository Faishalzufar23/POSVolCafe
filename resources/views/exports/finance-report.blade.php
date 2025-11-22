<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #f0f0f0;
            font-weight: bold;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: right;
        }
        .total-row {
            background: #dfeefa;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>Laporan Keuangan - POS VolCafe</h2>
    <p><strong>Tanggal: </strong>{{ now()->format('d/m/Y H:i') }}</p>

    @php
        $totalLabaKeseluruhan = $records->sum(fn($product) => $product->profitToday());
    @endphp

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga Jual</th>
                <th>Laba Perporsi</th>
                <th>Jumlah Terjual</th>
                <th>Laba Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>IDR {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>IDR {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->soldToday() }}</td>
                    <td>IDR {{ number_format($product->profitToday(), 0, ',', '.') }}</td>
                </tr>
            @endforeach

            <tr class="total-row">
                <td colspan="4">TOTAL LABA KESELURUHAN</td>
                <td>IDR {{ number_format($totalLabaKeseluruhan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
    </div>

</body>
</html>
