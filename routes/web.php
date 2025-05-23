<?php

use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware(['web'])->group(function () {
    //block frontend
    require __DIR__.'/frontend/home.php';
    require __DIR__.'/frontend/shop.php';
    require __DIR__.'/frontend/cart.php';
    require __DIR__.'/frontend/wishlist.php';
    require __DIR__.'/frontend/account.php';
    require __DIR__.'/frontend/about.php';
    require __DIR__.'/frontend/contact.php';
    require __DIR__.'/frontend/checkout.php';
    require __DIR__.'/frontend/review.php';
});

//block backend
require __DIR__.'/admin/dashboard.php';
require __DIR__.'/admin/brand.php';
require __DIR__.'/admin/category.php';
require __DIR__.'/admin/product.php';
require __DIR__.'/admin/coupon.php';
require __DIR__.'/admin/order.php';
require __DIR__.'/admin/slide.php';
require __DIR__.'/admin/contact.php';
require __DIR__.'/admin/user.php';
require __DIR__.'/admin/setting.php';
require __DIR__.'/admin/about.php';
require __DIR__.'/admin/category_banner.php';

//block auth
require __DIR__.'/auth.php';

// routes/web.php
require __DIR__.'/lang.php';
