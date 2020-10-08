<?php


namespace App\States\Invoices;

class SentState extends InvoiceState
{

    function getShortDescription(): string
    {
        return 'sent';
    }
}
