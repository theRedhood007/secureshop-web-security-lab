<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

// Book Routes
Route::resource('books', BookController::class);

// Cart Routes
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
Route::post('cart/remove/{book}', [CartController::class, 'remove'])->name('cart.remove');

// User Profile Routes
Route::get('profile', [UserController::class, 'show'])->name('profile.show');
Route::post('profile', [UserController::class, 'update'])->name('profile.update');