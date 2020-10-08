<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Invoice
     */
    public $invoice;

    public $pdfFilePath;

    /**
     * Create a new message instance.
     *
     * @param Invoice $invoice
     * @param $pdfFilePath
     */
    public function __construct(Invoice $invoice, $pdfFilePath)
    {
        $this->invoice = $invoice;
        $this->pdfFilePath = $pdfFilePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('invoices.mail',[
            'invoice' => $this->invoice
        ])->attachFromStorage($this->pdfFilePath);
    }
}
