<?php


namespace App\States\Invoices;

class ReceivedState extends InvoiceState
{

    function getShortDescription(): string
    {
        return 'received';
    }
}
