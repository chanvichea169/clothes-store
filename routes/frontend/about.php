<?php

use App\Http\Controllers\Frontend\AboutController;
use Illuminate\Support\Facades\Route;

Route::get('about/' ,[AboutController::class, 'index'])->name('about.index');
