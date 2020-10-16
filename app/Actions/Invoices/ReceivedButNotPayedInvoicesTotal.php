<?php


namespace App\Actions\Invoices;

use App\Models\Invoice;
use App\States\Invoices\ReceivedState;
use Cknow\Money\Money;

class ReceivedButNotPayedInvoicesTotal
{

    /**
     * @return Money
     */
    public function execute(): Money
    {


        $invoiceTotals = Invoice::where('state', ReceivedState::class)->with('items')->get()->map(function($invoice) {
            return $invoice->calcTotal()->getAmount();
        })->toArray();
        return Money::EUR(array_sum($invoiceTotals));
    }
}
