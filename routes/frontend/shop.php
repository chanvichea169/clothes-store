<?php

use App\Http\Controllers\Frontend\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/frontend/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/frontend/shop/{product_slug}', [ShopController::class, 'product_datails'])->name('shop.details');