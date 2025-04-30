<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});


//Google login
Route::controller(SocialAuthController::class)->group(function () {
    Route::get('auth/google',  'googlelogin')->name('auth.google');
    Route::get('/auth/google-callback','googleAuthentication')->name('auth.google-callback')
    ->middleware('web');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/show-change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('user.change.password');
    Route::put('/update-password', [ChangePasswordController::class, 'updatePassword'])->name('user.update.password');
});

// Password Reset Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');
