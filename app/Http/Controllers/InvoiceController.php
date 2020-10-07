<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        return Inertia::render('Invoices/Index',[
            'invoices' => $invoices
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Invoices/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InvoiceStoreRequest $request
     * @return RedirectResponse
     */
    public function store(InvoiceStoreRequest $request)
    {
        $data = $request->validated();
        $data['is_draft'] = true;
        $data['due_at'] = now()->addWeeks(2);
        $invoice = Invoice::create($data);
        return Redirect::route('invoices.show', ['invoice' => $invoice]);
    }

    /**
     * Display the specified resource.
     *
     * @param Invoice $invoice
     * @return Response
     */
    public function show(Invoice $invoice)
    {
        $lastUpdated = $invoice->updated_at->diffForHumans();
        return Inertia::render('Invoices/Show', [
            'invoice' => $invoice,
            'last_updated' => $lastUpdated,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $lastUpdated = $invoice->updated_at->diffForHumans();
        return Inertia::render('Invoices/Edit', [
            'invoice' => $invoice,
            'last_updated' => $lastUpdated,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceUpdateRequest $request, Invoice $invoice)
    {
        $data = $request->validated();
        $data['is_draft'] = true;
        $invoice->fill($data);
        $invoice->save();

        return Redirect::route('invoices.show', ['invoice' => $invoice]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
