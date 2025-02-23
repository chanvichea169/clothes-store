<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/admin/user', [UserController::class, 'admin_index'])->name('admin.user.index');
    Route::get('/admin/user/{id}', [UserController::class, 'admin_edit'])->name('admin.user.edit');
    Route::put('/admin/user/update', [UserController::class, 'admin_update'])->name('admin.user.update');
});