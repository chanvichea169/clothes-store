<?php

use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\PaypalController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    // Checkout Routes
    Route::prefix('frontend/checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/place_an_order', [CheckoutController::class, 'place_an_order'])->name('place.an.order');
        Route::get('/order-confirmation', [CheckoutController::class, 'order_confirmation'])->name('order.confirmation');
        Route::get('/payment/card', [CheckoutController::class, 'showCardPaymentForm'])->name('payment.card');
        Route::get('/stripe/return', [CheckoutController::class, 'handleStripeReturn'])->name('stripe.return');
    });

    // PayPal Routes
    Route::prefix('paypal')->name('paypal.')->group(function () {
        Route::match(['get', 'post'], '/create-order', [PaypalController::class, 'createOrder'])->name('create-order');
        Route::post('/capture-order', [PaypalController::class, 'captureOrder'])->name('capture-order');
        Route::get('/success', [PaypalController::class, 'success'])->name('success');
        Route::get('/cancel', [PaypalController::class, 'cancel'])->name('cancel');
    });
});
