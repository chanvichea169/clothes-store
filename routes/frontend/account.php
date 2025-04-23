<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // User Account Dashboard and Order Routes
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
    Route::get('/account-orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/account-order/{order_id}/details', [UserController::class, 'order_details'])->name('user.order.details');
    Route::put('/account-order/{order_id}/cancel', [UserController::class, 'cancel_order'])->name('user.order.cancel');

    // User Address Routes
    Route::get('/account-address', [UserController::class, 'address'])->name('user.address');
    Route::get('/user/address/add/{id}', [UserController::class, 'addAddress'])->name('user.address.add');
    Route::post('/user/address/store', [UserController::class, 'storeAddress'])->name('user.address.store');
    Route::get('/user/address/edit/{id}', [UserController::class, 'editAddress'])->name('user.address.edit');
    Route::put('/user/address/update/{id}', [UserController::class, 'updateAddress'])->name('user.address.update');

    // User Account Details
    Route::get('/account/details', [UserController::class, 'account_details'])->name('user.details');
});