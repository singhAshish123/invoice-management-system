<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::middleware(['role:' . \App\Enums\RoleEnum::USER->value])->group(function () {
        Route::resource('vendors', VendorController::class);
        Route::resource('products', ProductController::class);
        Route::resource('invoices', InvoiceController::class);

        Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
        Route::get('/invoices/{invoice}/mail', [InvoiceController::class, 'sendInvoice'])->name('invoices.mail');
    });
});

require __DIR__.'/auth.php';
