<?php

use App\Http\Controllers\Backend\CategoryController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;


#use category id
// Route::middleware(['auth', AuthAdmin::class])->group(function () {
//     Route::get('/admin/categories', [CategoryController::class, 'categories'])->name('admin.categories');
//     Route::get('/admin/category/add', [CategoryController::class, 'add_category'])->name('admin.add.category');
//     Route::post('/admin/category/store', [CategoryController::class, 'store_category'])->name('admin.store.category');
//     Route::get('/admin/category/edit/{id}', [CategoryController::class, 'edit_category'])->name('admin.edit.category');
//     Route::put('/admin/category/update', [CategoryController::class, 'update_category'])->name('admin.update.category');
//     Route::delete('/admin/category/delete/{id}', [CategoryController::class, 'delete_category'])->name('admin.delete.category');
// });

#use slug for category
Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('/admin/categories', [CategoryController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/category/add', [CategoryController::class, 'add_category'])->name('admin.add.category');
    Route::post('/admin/category/store', [CategoryController::class, 'store_category'])->name('admin.store.category');
    Route::get('/admin/category/edit/{slug}', [CategoryController::class, 'edit_category'])->name('admin.edit.category');
    Route::put('/admin/category/update', [CategoryController::class, 'update_category'])->name('admin.update.category');
    Route::delete('/admin/category/delete/{slug}', [CategoryController::class, 'delete_category'])->name('admin.delete.category');
});
