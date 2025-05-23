<?php

use App\Http\Controllers\Backend\AboutController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('about')->name('about.')->group(function () {
        Route::get('/', [AboutController::class, 'index'])->name('index');
        Route::get('/create', [AboutController::class, 'create'])->name('create');
        Route::post('/', [AboutController::class, 'store'])->name('store');
        Route::get('/{about}/edit', [AboutController::class, 'edit'])->name('edit');
        Route::put('/{about}', [AboutController::class, 'update'])->name('update');
        Route::delete('/{about}', [AboutController::class, 'destroy'])->name('destroy');
    });
});