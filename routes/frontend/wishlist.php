<?php

use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/frontend/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/frontend/wishlist/add', [WishlistController::class, 'add_to_wishlist'])->name('wishlist.add_to_wishlist');
Route::delete('/frontend/wishlist/remove/{rowId}', [WishlistController::class, 'remove_from_wishlist'])->name('wishlist.remove_from_wishlist');
Route::delete('/frontend/wishlist/empty', [WishlistController::class, 'empty'])->name('wishlist.empty');
Route::post('/frontend/wishlist/move_to_cart/{rowId}', [WishlistController::class, 'move_to_cart'])->name('wishlist.move_to_cart');