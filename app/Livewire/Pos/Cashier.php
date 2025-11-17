<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\ProductIngredient;
use App\Models\Ingredient;
use App\Models\IngredientUsage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Cashier extends Component
{
    public $products = [];
    public $cart = [];
    public $search = '';
    public $tax = 0;
    public $discount = 0;

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $query = Product::with('productIngredients.ingredient');

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        $this->products = $query->get()->toArray();
    }

    public function updatedSearch()
    {
        $this->loadProducts();
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        if (!isset($this->cart[$id])) {
            $this->cart[$id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => 1,
            ];
        } else {
            $this->cart[$id]['quantity']++;
        }
    }

    public function increment($id)
    {
        $this->cart[$id]['quantity']++;
    }

    public function decrement($id)
    {
        if ($this->cart[$id]['quantity'] > 1) {
            $this->cart[$id]['quantity']--;
        }
    }

    public function removeItem($id)
    {
        unset($this->cart[$id]);
    }

    public function getSubTotalProperty()
    {
        return collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    public function getTaxAmountProperty()
    {
        return ($this->tax / 100) * $this->subTotal;
    }

    public function getTotalProperty()
    {
        return ($this->subTotal + $this->taxAmount) - $this->discount;
    }

    public function checkout()
    {
        if (empty($this->cart)) {
            $this->dispatch('notify', message: 'Keranjang kosong!');
            return;
        }

        DB::beginTransaction();

        try {
            $invoice = 'INV-' . strtoupper(Str::random(8));

            $sale = Sale::create([
                'invoice_number' => $invoice,
                'user_id'        => Auth::id(),
                'items_count'    => collect($this->cart)->sum('quantity'),
                'sub_total'      => $this->subTotal,
                'tax'            => $this->taxAmount,
                'discount'       => $this->discount,
                'total'          => $this->total,
                'payment_status' => 'paid',
            ]);

            foreach ($this->cart as $item) {

                // 1. Simpan sale item (snapshot name)
                $saleItem = SaleItem::create([
                    'sale_id'   => $sale->id,
                    'product_id'=> $item['id'],
                    'name'      => $item['name'],
                    'quantity'  => $item['quantity'],
                    'price'     => $item['price'],
                    'line_total'=> $item['quantity'] * $item['price'],
                ]);

                // 2. Ambil resep produk
                $recipes = ProductIngredient::with('ingredient')
                    ->where('product_id', $item['id'])
                    ->get();

                foreach ($recipes as $recipe) {

                    $ingredient = $recipe->ingredient;

                    if (!$ingredient) {
                        throw new \Exception("Bahan baku tidak ditemukan untuk product_ingredient id {$recipe->id}");
                    }

                    // Hitung pemakaian bahan
                    $usedQty = $recipe->quantity * $item['quantity'];

                    // Pastikan stok cukup
                    if ($ingredient->stock < $usedQty) {
                        throw new \Exception(
                            "Stok bahan '{$ingredient->name}' kurang. Dibutuhkan {$usedQty} {$ingredient->unit}, tersisa {$ingredient->stock}."
                        );
                    }

                    // 3. Kurangi stok bahan
                    $ingredient->decrement('stock', $usedQty);

                    // 4. Simpan log pemakaian bahan
                    IngredientUsage::create([
                        'sale_id'       => $sale->id,
                        'product_id'    => $item['id'],
                        'ingredient_id' => $ingredient->id,
                        'quantity_used' => $usedQty,
                        'unit'          => $ingredient->unit,
                    ]);
                }
            }

            DB::commit();

            // Reset keranjang
            $this->cart = [];

            $this->dispatch('notify', message: 'Transaksi berhasil!');
            $this->loadProducts();

        } catch (\Throwable $e) {
            DB::rollBack();

            $this->dispatch('notify', message: 'Gagal checkout: ' . $e->getMessage());
            logger()->error('Checkout error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.pos.cashier');
    }
}
