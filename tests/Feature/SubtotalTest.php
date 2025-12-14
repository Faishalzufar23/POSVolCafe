<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Livewire\Pos\Cashier;
use Livewire\Livewire;

class SubtotalTest extends TestCase
{
    public function test_subtotal_calculation()
    {
        Livewire::test(Cashier::class)
            ->set('cart', [
                1 => ['id' => 1, 'name' => 'A', 'price' => 10000, 'quantity' => 2],
                2 => ['id' => 2, 'name' => 'B', 'price' => 5000, 'quantity' => 1],
            ])
            ->assertSet('subTotal', 25000);
    }
}
