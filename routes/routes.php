
<?php

use Andreracodex\Tripay\TripayController;
use Illuminate\Support\Facades\Route;

Route::prefix('tripay')->group(function () {
    Route::get('/instruction/{tripay}', [TripayController::class, 'instruction'])->name('tripay.instruction');
    Route::get('/merchant', [TripayController::class, 'merchant'])->name('tripay.merchant');
    Route::post('/merchantstore', [TripayController::class, 'merchantstore'])->name('tripay.merchantstore');
    Route::get('/callback', [TripayController::class, 'callback'])->name('tripay.callback');
    Route::get('/redirects', [TripayController::class, 'redirects'])->name('tripay.redirects');
    Route::get('/transaction/{tripay}/{invoices}/{amount}', [TripayController::class, 'transaction'])->name('tripay.transaction');
    Route::post('/short',  [TripayController::class, 'short'])->name('tripay.short');
    Route::get('/{code}', [TripayController::class, 'redirect'])->name('tripay.redirect');
});
