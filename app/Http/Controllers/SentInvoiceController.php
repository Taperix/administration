<?php

namespace App\Http\Controllers;

use App\Jobs\SentInvoiceJob;
use App\Models\Invoice;
use App\States\Invoices\SentState;
use Illuminate\Support\Facades\Redirect;

class SentInvoiceController extends Controller
{
    public function store(Invoice $invoice)
    {
        $invoice->state->transitionTo(SentState::class);
        $invoice->sent_when = now();
        $invoice->save();

        SentInvoiceJob::dispatchNow($invoice);

        return Redirect::route('invoices.show', ['invoice' => $invoice]);
    }
}
