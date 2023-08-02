<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('index',[HomeController::class,'index'])->name('index');

Route::get('categories',[CategoryController::class,'index'])->name('categories.index');
Route::get('categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('contact',[ContactController::class,'index'])->name('contact.index');
Route::post('contact',[ContactController::class,'store'])->name('contact.store');

Route::get('cart',[CartController::class,'index'])->name('cart.index');
Route::post('cart',[CartController::class,'store'])->name('cart.store');

Route::get('products',[ProductController::class,'index'])->name('products.index');
Route::get('products/{product}',[ProductController::class,'show'])->name('product.show');
Route::post('products',[ProductController::class,'store'])->name('products.store');

Route::get('checkout',[CheckoutController::class,'index'])->name('checkout.index');
Route::post('checkout',[CheckoutController::class,'store'])->name('checkout.store');

Route::get('detail',function (){
    return view('detail');
});

Route::get('shop',function (){
    return view('shop');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
