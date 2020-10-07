<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Invoice::factory()->count(20)->create()->each(function($invoice){
            $invoice->items()->create(InvoiceItem::factory()->make()->toArray());
            $invoice->items()->create(InvoiceItem::factory()->make()->toArray());
            $invoice->items()->create(InvoiceItem::factory()->make()->toArray());
        });
    }
}
