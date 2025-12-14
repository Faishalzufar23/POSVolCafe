<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Ingredient;
use App\Models\ProductIngredient;
use App\Models\IngredientUsage;
use Livewire\Livewire;
use App\Livewire\Pos\Cashier;

class IngredientUsageTest extends TestCase
{
    public function test_ingredient_usage_is_recorded()
    {
        $this->artisan('migrate:fresh');

        $user = User::factory()->create();
        $this->actingAs($user);

        $ing = Ingredient::create([
            'name' => 'Susu',
            'stock' => 500,
            'price' => 100,
            'unit' => 'ml'
        ]);

        $prod = Product::create([
            'name' => 'Latte',
            'price' => 20000
        ]);

        ProductIngredient::create([
            'product_id' => $prod->id,
            'ingredient_id' => $ing->id,
            'quantity' => 50
        ]);

        Livewire::test(Cashier::class)
            ->set('cart', [
                $prod->id => ['id' => $prod->id, 'name' => 'Latte', 'price' => 20000, 'quantity' => 1]
            ])
            ->set('paymentMethod', 'cash')
            ->set('cashAmount', 20000)
            ->call('checkout');

        $this->assertDatabaseHas('ingredient_usages', [
            'ingredient_id' => $ing->id,
            'quantity_used' => 50
        ]);
    }
}
