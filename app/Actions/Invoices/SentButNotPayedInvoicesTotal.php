<?php


namespace App\Actions\Invoices;

use App\Models\Invoice;
use App\States\Invoices\SentState;
use Cknow\Money\Money;

class SentButNotPayedInvoicesTotal
{

    /**
     * @return Money
     */
    public function execute(): Money
    {

        $invoiceTotals = Invoice::where('state', SentState::class)->with('items')->get()->map(function($invoice) {
            return $invoice->calcTotal()->getAmount();
        })->toArray();
        return Money::EUR(array_sum($invoiceTotals));
    }
}
