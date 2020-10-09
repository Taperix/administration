<?php

namespace App\Actions\Invoices;

use App\Actions\ImageToBase64;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade as PDF;

class GenerateInvoicePDF
{
    /**
     * @var Invoice
     */
    private $invoice;
    /**
     * @var string
     */
    private $path;

    private $generatedHTML;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function execute() {
        $data = [];
        $data['invoice'] = $this->invoice;
        $pdf = null;
        $data['logo'] = (new imageToBase64())->execute(config('company.logo'));

        $this->generatedHTML = view('invoices.pdf', $data)->render();
        $pdf = PDF::loadHTML($this->generatedHTML);

        $path = 'invoices/' . $this->invoice->id . '.pdf';
        $this->path = $path;
        $pdf->save(storage_path('app/' . $path ));

        return $this;
    }

    public function getPath() {
        return 'app/' . $this->path;
    }

    /**
     * @return mixed
     */
    public function getGeneratedHTML()
    {
        return $this->generatedHTML;
    }
}
