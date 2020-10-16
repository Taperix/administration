<?php

namespace App\Http\Controllers;

use App\Actions\ImageToBase64;
use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\States\Invoices\ReceivedState;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the Invoice.
     *
     * @return Response
     */
    public function index()
    {
        $invoices = Invoice::all()->each(function(Invoice $invoice) {
           $invoice->state = $invoice->state->getShortDescription();
        });
        $states = $invoices->groupBy('state');
        return Inertia::render('Invoices/Index',[
            'states' => $states
        ]);
    }

    /**
     * Show the form for creating a new Invoice.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Invoices/Create');
    }

    /**
     * Store a newly created Invoice in storage.
     *
     * @param InvoiceStoreRequest $request
     * @return RedirectResponse
     */
    public function store(InvoiceStoreRequest $request)
    {
        $data = $request->validated();
        $data['due_at'] = now()->addWeeks(2);
        $invoice = Invoice::create($data);
        if($request->has('incoming') && $request->get('incoming')) {
            $invoice->state->transitionTo(ReceivedState::class);
        }
        return Redirect::route('invoices.show', ['invoice' => $invoice]);
    }

    /**
     * Display the specified Invoice.
     *
     * @param Invoice $invoice
     * @return View
     */
    public function show(Invoice $invoice)
    {
        $data = [];
        $data['invoice'] = $invoice;
        $data['logo'] = (new imageToBase64())->execute(config('company.logo'));
        return view('invoices.pdf', $data);
    }

    /**
     * Show the form for editing the specified Invoice.
     *
     * @param Invoice $invoice
     * @return Response
     */
    public function edit(Invoice $invoice)
    {
        $lastUpdated = $invoice->updated_at->diffForHumans();
        return Inertia::render('Invoices/Edit', [
            'invoice' => $invoice,
            'last_updated' => $lastUpdated,
            'items' => $invoice->items,
            'all_items' => InvoiceItem::all(),
        ]);
    }

    /**
     * Update the specified Invoice in storage.
     *
     * @param InvoiceUpdateRequest $request
     * @param Invoice $invoice
     * @return RedirectResponse
     */
    public function update(InvoiceUpdateRequest $request, Invoice $invoice)
    {
        $data = $request->validated();

        $ids = collect($data['items'])->map(function($item) { return $item['id']; });
        foreach($invoice->items as $item) {
            $invoice->items()->detach($item->id);
        }

        $invoice->items()->attach($ids);
        $data['updated_at'] = now();
        $invoice->fill($data);
        $invoice->save();

        return Redirect::route('invoices.show', ['invoice' => $invoice]);
    }

    /**
     * Remove the specified Invoice from storage.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
