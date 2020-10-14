<?php


namespace App\States\Invoices;

class PaidState extends InvoiceState
{

    function getShortDescription(): string
    {
        return 'paid';
    }
}
