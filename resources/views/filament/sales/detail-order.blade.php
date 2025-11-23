<div>
    <h2 class="font-bold text-lg mb-3">Detail Pesanan</h2>

    <table class="w-full text-sm border">
        <tr class="border-b">
            <th class="text-left p-2">Menu</th>
            <th class="text-left p-2">Qty</th>
            <th class="text-left p-2">Subtotal</th>
        </tr>

        @foreach($items as $item)
        <tr class="border-b">
            <td class="p-2">{{ $item->product->name }}</td>
            <td class="p-2">{{ $item->quantity }}</td>
            <td class="p-2">IDR {{ number_format($item->line_total) }}</td>
        </tr>
        @endforeach
    </table>
</div>
