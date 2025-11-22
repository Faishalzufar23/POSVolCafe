<div class="grid grid-cols-12 gap-6">

    {{-- PRODUK --}}
    <div class="col-span-8">
        <input type="text" wire:model.live="search" class="w-full border rounded p-2 mb-4" placeholder="Cari produk...">

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($products as $p)
                <div class="p-4 border rounded-lg shadow hover:shadow-md transition">

                    @if (!empty($p['photo']))
                        <img src="{{ asset('storage/products/' . $p['photo']) }}" class="w-20 h-20 object-cover rounded">
                    @endif


                    <h3 class="font-semibold">{{ $p['name'] }}</h3>
                    <p>Rp {{ number_format($p['price']) }}</p>

                    <button wire:click="addToCart({{ $p['id'] }})"
                        class="mt-3 bg-blue-600 text-white px-3 py-1 rounded">
                        Tambah
                    </button>
                </div>

            @empty
                <p class="col-span-4 text-gray-500 text-center">
                    Produk tidak ditemukan
                </p>
            @endforelse
        </div>
    </div>

    {{-- KERANJANG --}}
    <div class="col-span-4 bg-white rounded-lg border shadow p-4 sticky top-4">
        <h2 class="font-bold text-lg mb-4">Keranjang</h2>

        @forelse ($cart as $id => $item)
            <div wire:key="cart-{{ $id }}" class="flex justify-between mb-3">
                <div>
                    <strong>{{ $item['name'] }}</strong><br>
                    <small>Rp {{ number_format($item['price']) }}</small>
                </div>
                <div class="flex items-center gap-2">
                    <button wire:click="decrement({{ $id }})" class="px-2 border rounded">-</button>

                    <span class="w-6 text-center">{{ $item['quantity'] }}</span>

                    <button wire:click="increment({{ $id }})" class="px-2 border rounded">+</button>

                    <button wire:click="removeItem({{ $id }})" class="text-red-500">x</button>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-sm text-center mt-4">
                Keranjang masih kosong
            </p>
        @endforelse

        <hr class="my-3">

        <div class="space-y-2 text-sm">
            <div>Subtotal: <strong>Rp {{ number_format($this->subTotal) }}</strong></div>
            <div>Pajak (%): <input type="number" wire:model="tax" class="border w-20 p-1 rounded"></div>
            <div>Diskon (Rp): <input type="number" wire:model="discount" class="border w-20 p-1 rounded"></div>
            <div class="text-xl mt-3">TOTAL:
                <strong>Rp {{ number_format($this->total) }}</strong>
            </div>
        </div>

        @if (!empty($cart))
            <button wire:click="$set('showPaymentModal', true)"
                class="bg-green-600 text-white px-3 py-2 rounded w-full mt-4">
                Checkout
            </button>
        @endif

    </div>

    {{-- MODAL PAYMENT --}}
    @if ($showPaymentModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-[520px] shadow-lg">

                {{-- Step 1 --}}
                @if ($stepPayment === 1)
                    <h2 class="text-lg font-bold mb-4 text-center">Pilih Metode Pembayaran</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <button wire:click="selectPaymentMethod('cash')"
                            class="p-4 border rounded-lg text-center bg-gray-100 hover:bg-green-200">
                            💵 Cash
                        </button>

                        <button wire:click="selectPaymentMethod('qris')"
                            class="p-4 border rounded-lg text-center bg-gray-100 hover:bg-blue-200">
                            📱 QRIS
                        </button>
                    </div>
                @endif

                {{-- Step 2 Cash --}}
                @if ($stepPayment === 2)
                    <h2 class="text-lg font-bold mb-4">Pembayaran Cash</h2>

                    <label class="text-sm font-semibold">Masukkan Uang Cash:</label>
                    <input type="number" wire:model="cashAmount" wire:keyup="calculateChange"
                        class="border rounded p-2 w-full mt-1" placeholder="Nominal uang tunai">

                    @if ($cashAmount)
                        <p class="mt-3 text-sm">
                            Total: <strong>Rp {{ number_format($this->total) }}</strong><br>
                            Kembalian:
                            <strong class="text-green-600">Rp {{ number_format($changeAmount) }}</strong>
                        </p>
                    @endif

                    <div class="flex justify-end gap-2 mt-6">
                        <button wire:click="$set('showPaymentModal', false)"
                            class="px-3 py-2 bg-gray-500 text-white rounded">
                            Batal
                        </button>

                        <button wire:click="confirmCashPayment" class="px-3 py-2 bg-green-600 text-white rounded">
                            Konfirmasi
                        </button>
                    </div>
                @endif

                {{-- Step 3 QRIS --}}
                @if ($stepPayment === 3)
                    <h2 class="text-lg font-bold mb-4 text-center">Scan QRIS</h2>

                    <div class="text-center">
                        <img src="/images/qris-example.png" class="w-52 mx-auto border rounded">
                        <p class="mt-3">Total:
                            <strong>Rp {{ number_format($this->total) }}</strong>
                        </p>
                    </div>

                    <div class="flex justify-end gap-2 mt-6">
                        <button wire:click="$set('showPaymentModal', false)"
                            class="px-3 py-2 bg-gray-500 text-white rounded">
                            Batal
                        </button>

                        <button wire:click="confirmQrisPayment" class="px-3 py-2 bg-blue-600 text-white rounded">
                            Pembayaran Selesai
                        </button>
                    </div>
                @endif

            </div>
        </div>
    @endif

    {{-- MODAL SUCCESS --}}
    @if ($showSuccessModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">

                <h2 class="text-xl font-bold text-green-600 mb-4">
                    {{ $successMessage }}
                </h2>

                <p class="text-lg font-semibold">
                    Total: Rp {{ number_format($this->total) }}
                </p>

                @if ($successChange !== null)
                    <p class="mt-2 text-md">
                        Kembalian:
                        <span class="font-bold text-blue-600">
                            Rp {{ number_format($successChange) }}
                        </span>
                    </p>
                @endif

                <div class="flex justify-center gap-3 mt-6">
                    <button class="px-4 py-2 bg-gray-700 text-white rounded"
                        wire:click="$set('showSuccessModal', false)">
                        Tutup
                    </button>

                    <button class="px-4 py-2 bg-green-600 text-white rounded" wire:click="printReceipt">
                        Cetak Struk
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>
