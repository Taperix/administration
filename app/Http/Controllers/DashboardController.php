<?php

namespace App\Http\Controllers;

use App\Actions\Bunq\BunqGetBalance;
use App\Actions\Invoices\ReceivedButNotPayedInvoicesTotal;
use App\Actions\Invoices\SentButNotPayedInvoicesTotal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Dashboard',
        [
            'current_balance' => [
                'value' => (new BunqGetBalance())->execute()->getValue(),
                'currency' => 'EUR',
            ],
            'open_outgoing_invoices' => [
                'value' => (new SentButNotPayedInvoicesTotal())->execute()->formatByDecimal(),
                'currency' => 'EUR'
            ],
            'open_incoming_invoices' => [
                'value' => (new ReceivedButNotPayedInvoicesTotal())->execute()->formatByDecimal(),
                'currency' => 'EUR'
            ],
        ]);
    }
}
