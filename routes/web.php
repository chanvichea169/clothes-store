<?php
use Illuminate\Support\Facades\Auth;

Auth::routes();

//block frontend
require __DIR__.'/frontend/home.php';
require __DIR__.'/frontend/shop.php';
require __DIR__.'/frontend/cart.php';
require __DIR__.'/frontend/wishlist.php';
require __DIR__.'/frontend/account.php';
require __DIR__.'/frontend/about.php';
require __DIR__.'/frontend/contact.php';
require __DIR__.'/frontend/checkout.php';

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