<?php

use App\Http\Controllers\Backend\CouponController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/coupon', [CouponController::class, 'index'])->name('admin.coupons');
Route::get('/admin/coupon/add-coupon', [CouponController::class, 'create'])->name('admin.coupon.add-coupon');
Route::post('/admin/coupon/store', [CouponController::class, 'store'])->name('admin.coupon.store');
Route::get('/admin/coupon/edit/{id}', [CouponController::class, 'edit'])->name('admin.coupon.edit');
Route::put('/admin/coupon/{id}/update', [CouponController::class, 'update'])->name('admin.coupon.update');
Route::delete('/admin/coupon/delete/{id}', [CouponController::class, 'destroy'])->name('admin.coupon.delete');
Route::post('admin/coupon/apply-coupon', [CouponController::class, 'apply_coupon_code'])->name('apply.coupon');
Route::delete('admin/coupon/remove-coupon', [CouponController::class, 'remove_coupon_code'])->name('coupon.remove');
