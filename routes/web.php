<?php
use Illuminate\Support\Facades\Auth;

Auth::routes();

//block frontend
require __DIR__.'/frontend/home.php';
require __DIR__.'/frontend/shop.php';
require __DIR__.'/frontend/cart.php';
require __DIR__.'/frontend/account.php';

//block backend
require __DIR__.'/backend/dashboard.php';
require __DIR__.'/backend/brand.php';
require __DIR__.'/backend/category.php';
require __DIR__.'/backend/product.php';