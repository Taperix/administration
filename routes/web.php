<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoicePdfController;
use App\Http\Controllers\ReadyInvoiceController;
use App\Http\Controllers\SentInvoiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function() {
        return Inertia\Inertia::render('Dashboard');
    });
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/pdf', InvoicePdfController::class);
    Route::get('invoices/{invoice}/pdf/preview', [InvoicePdfController::class, 'preview'])->name('invoices.pdf.preview');
    Route::put('invoices/{invoice}/sent', [SentInvoiceController::class, 'store']);
    Route::put('invoices/{invoice}/ready', [ReadyInvoiceController::class, 'store']);
});
