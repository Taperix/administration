<?php

namespace Tests\Unit;

use App\Actions\Invoices\GenerateInvoicePDF;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerateInvoicePDFTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itGeneratesAPDF()
    {
        // setup
        User::factory()->create();
        $invoice = Invoice::factory()->create();

        //action
        $generator = new GenerateInvoicePDF($invoice);
        $generator->execute();

        // assertion
        $this->assertFileExists(storage_path($generator->getPath()));
    }

    /** @test */
    public function itHasTheText()
    {
        // setup
        User::factory()->create();
        $invoice = Invoice::factory()->create();

        //action
        $generator = new GenerateInvoicePDF($invoice);
        $generator->execute();
        $html = $generator->getGeneratedHTML();

        // assertion
        $this->assertStringContainsString($invoice->id, $html);
        $this->assertStringContainsString(config('company.name'), $html);
        $this->assertStringContainsString($invoice->due_at->format('M d, Y'), $html);
        $this->assertStringContainsString($invoice->created_at->format('M d, Y'), $html);
        $this->assertStringContainsString('total', $html);
        $this->assertFileExists(storage_path($generator->getPath()));
    }

    /** @test */
    public function checkIfTotalIsInPDFWithoutRows()
    {
        // setup
        User::factory()->create();
        $invoice = Invoice::factory()->create();

        //action
        $generator = new GenerateInvoicePDF($invoice);
        $generator->execute();
        $html = $generator->getGeneratedHTML();

        // assertion
        $this->assertStringContainsString($invoice->calcTotal(), $html);
    }

    /** @test */
    public function checkIfPDFHasTotalWithRows()
    {
        // setup
        User::factory()->create();
        $invoice = Invoice::factory()->create();
        InvoiceItem::factory()->create([
            'price' => 100,
             'invoice_id' => $invoice->id
        ]);
        InvoiceItem::factory()->create([
            'price' => 100,
            'invoice_id' => $invoice->id
        ]);
        InvoiceItem::factory()->create([
            'price' => 100,
            'invoice_id' => $invoice->id
        ]);

        //action
        $generator = new GenerateInvoicePDF($invoice);
        $generator->execute();
        $html = $generator->getGeneratedHTML();

        // assertion
        $this->assertStringContainsString($invoice->calcTotal(), $html);
    }
}
