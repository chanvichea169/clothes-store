<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
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

//github login
Route::controller(SocialAuthController::class)->group(function () {
    Route::get('auth/github',  'githublogin')->name('auth.github');
    Route::get('/auth/github-callback','githubAuthentication')->name('auth.github-callback')
    ->middleware('web');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/show-change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('user.change.password');
    Route::put('/update-password', [ChangePasswordController::class, 'updatePassword'])->name('user.update.password');
});