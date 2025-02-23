<?php

use App\Http\Controllers\Backend\BrandController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('/admin/brands', [BrandController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brand/add', [BrandController::class, 'add_brand'])->name('admin.add.brand');
    Route::post('/admin/brand/store', [BrandController::class, 'store_brand'])->name('admin.store.brand');
    Route::get('/admin/brand/edit/{id}', [BrandController::class, 'edit_brand'])->name('admin.edit.brand');
    Route::put('/admin/brand/update', [BrandController::class, 'update_brand'])->name('admin.update.brand');
    Route::delete('/admin/brand/delete/{id}', [BrandController::class, 'delete_brand'])->name('admin.delete.brand');
});