<?php

use App\Http\Controllers\Backend\CategoryBannerController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/category-banners', [CategoryBannerController::class, 'index'])->name('category-banners.index');
    Route::get('/category-banners/create', [CategoryBannerController::class, 'create'])->name('category-banners.create');
    Route::post('/category-banners', [CategoryBannerController::class, 'store'])->name('category-banners.store');
    Route::get('/category-banners/{categoryBanner}/edit', [CategoryBannerController::class, 'edit'])->name('category-banners.edit');
    Route::put('/category-banners/{categoryBanner}', [CategoryBannerController::class, 'update'])->name('category-banners.update');
    Route::delete('/category-banners/{categoryBanner}', [CategoryBannerController::class, 'destroy'])->name('category-banners.destroy');
});
