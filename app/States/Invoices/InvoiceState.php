<?php


namespace App\States\Invoices;


use Spatie\ModelStates\State;

abstract class InvoiceState extends State
{
    abstract function getShortDescription() : string;
}
