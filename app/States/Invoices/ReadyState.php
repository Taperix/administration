<?php


namespace App\States\Invoices;


use Spatie\ModelStates\State;

class ReadyState extends InvoiceState
{

    function getShortDescription(): string
    {
        return 'ready';
    }
}
