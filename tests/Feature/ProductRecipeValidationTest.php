<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\ProductIngredient;
use App\Models\Ingredient;

class ProductRecipeValidationTest extends TestCase
{
    public function test_recipe_requires_valid_ingredient()
    {
        $this->artisan('migrate:fresh');

        $product = Product::create(['name' => 'Es Jeruk', 'price' => 10000]);

        $ingredient = Ingredient::create([
            'name' => 'Jeruk',
            'price' => 200,
            'stock' => 200,
            'unit' => 'gram'
        ]);

        ProductIngredient::create([
            'product_id' => $product->id,
            'ingredient_id' => $ingredient->id,
            'quantity' => 30
        ]);

        $this->assertDatabaseHas('product_ingredients', [
            'product_id' => $product->id,
            'ingredient_id' => $ingredient->id
        ]);
    }
}
