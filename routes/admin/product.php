<?php

use App\Http\Controllers\Backend\ProductController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;

#use id for product
// Route::middleware(['auth', AuthAdmin::class])->group(function () {
//     Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products');
//     Route::get('/admin/product/add', [ProductController::class, 'add_product'])->name('admin.add.product');
//     Route::post('/admin/product/store', [ProductController::class, 'store_product'])->name('admin.store.product');
//     Route::get('/admin/product/edit/{id}', [ProductController::class, 'edit_product'])->name('admin.edit.product');
//     Route::put('/admin/product/update/{id}', [ProductController::class, 'update_product'])->name('admin.update.product');
//     Route::delete('/admin/product/delete/{id}', [ProductController::class, 'delete_product'])->name('admin.delete.product');
//     Route::get('/get-brands-by-category', [ProductController::class, 'getBrandsByCategory']);
// });

#use slug for product
Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products');
    Route::get('/admin/product/add', [ProductController::class, 'add_product'])->name('admin.add.product');
    Route::post('/admin/product/store', [ProductController::class, 'store_product'])->name('admin.store.product');

    // Updated to use slug
    Route::get('/admin/product/edit/{slug}', [ProductController::class, 'edit_product'])->name('admin.edit.product');
    Route::put('/admin/product/update/{slug}', [ProductController::class, 'update_product'])->name('admin.update.product');
    Route::delete('/admin/product/delete/{slug}', [ProductController::class, 'delete_product'])->name('admin.delete.product');

    Route::get('/get-brands-by-category', [ProductController::class, 'getBrandsByCategory']);
});