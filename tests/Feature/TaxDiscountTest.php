<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Livewire\Pos\Cashier;
use Livewire\Livewire;

class TaxDiscountTest extends TestCase
{
    public function test_tax_and_discount_calculation()
    {
        Livewire::test(Cashier::class)
            ->set('cart', [
                1 => ['id' => 1, 'name' => 'A', 'price' => 20000, 'quantity' => 1],
            ])
            ->set('tax', 10)
            ->set('discount', 2000)
            ->assertSet('subTotal', 20000)
            ->assertSet('taxAmount', 2000)
            ->assertSet('total', 20000 + 2000 - 2000);
    }
}
