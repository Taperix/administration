<?php


namespace App\States\Invoices;

class ReadyState extends InvoiceState
{

    function getShortDescription(): string
    {
        return 'ready';
    }
}
