<?php

namespace App\Http\Controllers;

use App\Actions\ImageToBase64;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade as PDF;

class InvoicePdfController extends Controller
{
    public function __invoke(Invoice $invoice)
    {
        $data = [];
        $data['invoice'] = $invoice;
        $data['logo'] = (new imageToBase64())->execute(config('company.logo'));
        $pdf = PDF::loadView('invoices.pdf', $data);
        return $pdf->download('invoice.pdf');
    }

    public function preview(Invoice $invoice) {
        $data = [];
        $data['invoice'] = $invoice;
        $data['logo'] = (new imageToBase64())->execute(config('company.logo'));
        return view('invoices.pdf', $data);
    }
}
