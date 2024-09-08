<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::get('index',[HomeController::class,'index'])->name('index');

Route::get('categories',[CategoryController::class,'index'])->name('categories.index');
Route::get('categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('contact', [ContactController::class, 'create'])->name('contacts.create');
Route::post('contact',[ContactController::class,'store'])->name('contacts.store');

Route::get('cart',[CartController::class,'index'])->name('cart.index');
Route::post('cart',[CartController::class,'store'])->name('cart.store');
Route::patch('/cart/{product}', [CartController::class,'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class,'destroy'])->name('cart.destroy');

Route::get('products',[ProductController::class,'index'])->name('products.index');
Route::get('products/{product}',[ProductController::class,'show'])->name('products.show');
Route::post('products',[ProductController::class,'store'])->name('products.store');


Route::post('coupon',[CouponController::class,'store'])->name('coupon.store');
Route::delete('coupon',[CouponController::class,'destroy'])->name('coupon.destroy');

Route::get('checkout',[CheckoutController::class,'index'])->name('checkout.index');
Route::post('checkout',[CheckoutController::class,'store'])->name('checkout.store');

Route::get('thankyou', [ConfirmationController::class,'index'])->name('confirmation.index');

Route::get('faq', [FaqController::class, 'index'])->name('faq.index');

Route::get('shop',[ShopController::class,'index'])->name('shop.index');
Route::get('/shop/filter', [ShopController::class,'filter'])->name('shop.filter');


Route::post('products/{product}/rate',[ProductController::class, 'rate'])->name('products.rate');

Route::post('products/{product_id}/review', [ReviewController::class, 'store'])->name('review.store');

Route::get('payment', [PaypalController::class, 'payment'])->name('payment');
Route::get('cancel', [PaypalController::class, 'cancel'])->name('payment.cancel');

Route::get('payment/success', [PaypalController::class, 'success'])->name('payment.success');
Route::post('search', [ProductController::class, 'search'])->name('search');
Route::get('/reviews', [ReviewController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
