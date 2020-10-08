<?php


namespace App\States\Invoices;


use Spatie\ModelStates\State;

class SentState extends InvoiceState
{

    function getShortDescription(): string
    {
        return 'sent';
    }
}
