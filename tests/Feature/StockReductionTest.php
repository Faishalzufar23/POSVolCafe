<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Ingredient;
use App\Models\ProductIngredient;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Pos\Cashier;

class StockReductionTest extends TestCase
{
    public function test_stock_reduces_after_checkout()
    {
        $this->artisan('migrate:fresh');

        $user = User::factory()->create();
        $this->actingAs($user);

        $ingredient = Ingredient::create([
            'name' => 'Gula',
            'price' => 100,
            'stock' => 1000,
            'unit' => 'gram'
        ]);

        $product = Product::create([
            'name' => 'Teh',
            'price' => 10000
        ]);

        ProductIngredient::create([
            'product_id' => $product->id,
            'ingredient_id' => $ingredient->id,
            'quantity' => 10
        ]);

        Livewire::test(Cashier::class)
            ->set('cart', [
                $product->id => ['id' => $product->id, 'name' => 'Teh', 'price' => 10000, 'quantity' => 2]
            ])
            ->set('paymentMethod', 'cash')
            ->set('cashAmount', 30000)
            ->call('checkout');

        $ingredient->refresh();

        $this->assertEquals(1000 - (10 * 2), $ingredient->stock);
    }
}
