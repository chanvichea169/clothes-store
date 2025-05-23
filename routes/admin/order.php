<?php

use App\Http\Controllers\Backend\OrderController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('/admin/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/admin/order/{order_id}/details', [OrderController::class, 'order_details'])->name('order.details');
    Route::put('/admin/order/{order_id}/order-status', [OrderController::class, 'update_order_status'])->name('update.order.status');
});