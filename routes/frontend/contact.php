<?php

use App\Http\Controllers\Frontend\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/contact' ,[ContactController::class, 'index'])->name('contact.index');