<?php

use App\Http\Controllers\Backend\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('admin/contact', [ContactController::class, 'index'])->name('admin.contact.index');
Route::delete('admin/contact/{id}', [ContactController::class, 'destroy'])->name('admin.contact.destroy');