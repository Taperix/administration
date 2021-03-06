<?php

namespace Tests\Unit;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTotalCalculationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    protected $user;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    protected $invoice;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->invoice = Invoice::factory()->create();
    }

    /** @test */
    public function returns0WhenNoInvoiceItemsArePresent()
    {
        $this->assertSame(0, (int) $this->invoice->calcTotal()->getAmount());
    }

    /** @test */
    public function returnsTheRightAmountWith1Item()
    {
        $this->invoice->items()->create([
            'text' => '',
            'price' => 100,
        ]);
        $this->assertSame(100, (int) $this->invoice->calcTotal()->getAmount());
    }

    /** @test */
    public function returnsTheRightAmountWithMultipleItems()
    {
        $this->invoice->items()->create([
            'text' => '',
            'price' => 100,
        ]);
        $this->invoice->items()->create([
            'text' => '',
            'price' => 100,
        ]);
        $this->invoice->items()->create([
            'text' => '',
            'price' => 100,
        ]);
        $this->assertSame(300, (int) $this->invoice->calcTotal()->getAmount());
    }
}
