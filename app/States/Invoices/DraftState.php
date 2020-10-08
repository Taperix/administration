<?php


namespace App\States\Invoices;

class DraftState extends InvoiceState
{

    function getShortDescription(): string
    {
        return 'draft';
    }
}
