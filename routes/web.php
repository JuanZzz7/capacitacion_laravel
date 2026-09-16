<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Public Catalog & Product Detail
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/catalogo', [ProductController::class, 'index'])->name('catalog.index');
Route::get('/producto/{slug}', [ProductController::class, 'show'])->name('product.show');

// Shopping Cart & Checkout
Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrito/agregar', [CartController::class, 'store'])->name('cart.store');
Route::patch('/carrito/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrito/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/carrito/cupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
Route::post('/carrito/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Authentication (Dual Login / Register tabs)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/registro', fn () => redirect()->route('login', ['tab' => 'register']))->name('register');
Route::post('/registro', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
