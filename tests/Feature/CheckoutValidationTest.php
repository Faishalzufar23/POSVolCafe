<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Pos\Cashier;
use App\Models\User;

class CheckoutValidationTest extends TestCase
{
    public function test_checkout_fails_when_cart_empty()
    {
        Livewire::test(Cashier::class)
            ->call('checkout')
            ->assertDispatched('notify');
    }
}
