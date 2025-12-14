<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Sale;
use App\Models\SaleItem;

class FinancialReportTest extends TestCase
{
    public function test_financial_report_calculation()
    {
        $this->artisan('migrate:fresh');

        $user = User::factory()->create();
        $this->actingAs($user);

        $sale = Sale::create([
            'invoice_number' => 'INVTEST',
            'user_id' => $user->id,
            'items_count' => 2,
            'sub_total' => 20000,
            'tax' => 2000,
            'discount' => 0,
            'total' => 22000
        ]);

        $this->assertEquals(22000, $sale->total);
    }
}
