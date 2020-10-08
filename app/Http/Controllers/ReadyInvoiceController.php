<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\States\Invoices\ReadyState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ReadyInvoiceController extends Controller
{
    //

    public function store(Invoice $invoice) {
        $invoice->state->transitionTo(ReadyState::class);
        return Redirect::route('invoices.show', ['invoice' => $invoice]);
    }
}
