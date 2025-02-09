<?php

use App\Http\Controllers\Frontend\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::prefix('frontend/checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/place_an_order', [CheckoutController::class, 'place_an_order'])->name('place.an.order');
    Route::get('/order-confirmation', [CheckoutController::class, 'order_confirmation'])->name('order.confirmation');
});
