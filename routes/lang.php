<?php

use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/change-language/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'km'])) {
        session(['locale' => $lang]);
        App::setLocale($lang);
    }

    return redirect()->back();
})->name('change.language');
