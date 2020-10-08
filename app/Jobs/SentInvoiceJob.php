<?php

namespace App\Jobs;

use App\Actions\Invoices\GenerateInvoicePDF;
use App\Mail\InvoiceMail;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SentInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Invoice
     */
    private $invoice;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        //
        $this->invoice = $invoice;
    }

    /**
     * Execute the job.
     *
     * @param Invoice $invoice
     * @return void
     */
    public function handle()
    {

        $pdfPath = (new GenerateInvoicePDF($this->invoice))->execute()->getPath();

        Mail::to($this->invoice->recipient->email)
            ->bcc('info@taperix.com')->send(new InvoiceMail($this->invoice, $pdfPath));
    }
}
