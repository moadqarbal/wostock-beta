<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



// Users
Route::get('/register' , [UserController::class , 'create'])->name('users.create')->middleware('guest');
Route::post('/users' , [UserController::class , 'store'])->name('users.store')->middleware('guest');
Route::get('/login', [UserController::class, 'login'])->name('users.login')->middleware('guest');
Route::post('/authenticate', [UserController::class, 'authenticate'])->name('authenticate')->middleware('guest');
Route::post('/logout', [UserController::class, 'logout'])->name('users.logout')->middleware('auth');

// Password Reset
Route::get('/forgot-password', [PasswordController::class, 'request'])->name('password.request')->middleware('guest');
Route::post('/forgot-password', [PasswordController::class, 'email'])->name('password.email')->middleware('guest');
Route::get('/reset-password/{token}', [PasswordController::class, 'reset'])->name('password.reset')->middleware('guest');
Route::post('/reset-password', [PasswordController::class, 'update'])->name('password.update')->middleware('guest');


// Dashboard
Route::get('/' , [DashboardController::class , 'index'])->name('dashboard.index')->middleware('auth');


// Products
Route::get('/products' , [ProductController::class , 'index'])->name('products.index')->middleware('auth');