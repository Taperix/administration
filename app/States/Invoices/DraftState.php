<?php


namespace App\States\Invoices;


use Spatie\ModelStates\State;

class DraftState extends InvoiceState
{

    function getShortDescription(): string
    {
        return 'draft';
    }
}
