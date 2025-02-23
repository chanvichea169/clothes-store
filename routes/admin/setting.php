<?php

use App\Http\Controllers\Backend\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/setting/', [SettingController::class, 'index'])->name('admin.setting.index');