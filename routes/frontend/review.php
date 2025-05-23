<?php

use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/products/{product}', [ReviewController::class, 'show']);
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');