<?php

use App\Http\Controllers\Backend\SlideController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/slide/', [SlideController::class, 'index'])->name('admin.slide.index');
Route::get('/admin/slide/create', [SlideController::class, 'create'])->name('admin.slide.create');
Route::post('/admin/slide/store', [SlideController::class, 'store'])->name('admin.slide.store');
Route::get('/admin/slide/edit/{id}', [SlideController::class, 'edit'])->name('admin.slide.edit');
Route::put('/admin/slide/update/{id}', [SlideController::class, 'update'])->name('admin.slide.update');
Route::delete('/admin/slide/delete/{id}', [SlideController::class, 'destroy'])->name('admin.slide.delete');