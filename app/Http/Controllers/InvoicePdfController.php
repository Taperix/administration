<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade as PDF;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class InvoicePdfController extends Controller
{
    public function __invoke(Invoice $invoice)
    {
        $data = [];
        $data['invoice'] = $invoice;
        $pdf = null;
        $image = $this->imageToBase(config('company.logo'));
        $data['logo'] = $image;
        try {
            $pdf = PDF::loadView('invoices.pdf', $data);
            return view('invoices.pdf', $data);
            return $pdf->download('invoice.pdf');
        }catch(\ErrorException $errorException) {
            dd($errorException);
            return $pdf->download('invoice.pdf');
        }
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
