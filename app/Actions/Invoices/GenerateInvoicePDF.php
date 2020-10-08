<?php

namespace App\Actions\Invoices;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Cache;

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

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function execute() {
        $data = [];
        $data['invoice'] = $this->invoice;
        $pdf = null;
        $image = $this->imageToBase(config('company.logo'));
        $data['logo'] = $image;

        $pdf = PDF::loadView('invoices.pdf', $data);

        $path = 'invoices/' . $this->invoice->id . '.pdf';
        $this->path = $path;
        $pdf->save(storage_path('app/' . $path ));

        return $this;
    }

    public function getPath() {
        return $this->path;
    }

    private function imageToBase($image)
    {
        if(Cache::has($image)) {
            return Cache::get($image);
        }
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $data = file_get_contents($image);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        Cache::put($image, $base64, now()->addYear());

        return $base64;
    }
}
