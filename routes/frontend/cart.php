<?php



use App\Http\Controllers\Frontend\CartController;
use Illuminate\Support\Facades\Route;

Route::prefix('frontend/cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add_to_cart'])->name('add');
    Route::put('/increase/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('qty.increase');
    Route::put('/decrease/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('qty.decrease');
    Route::delete('/remove/{rowId}', [CartController::class, 'remove_from_cart'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear_cart'])->name('clear');
});