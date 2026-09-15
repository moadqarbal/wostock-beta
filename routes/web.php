<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
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
Route::get('/analytics' , [DashboardController::class , 'analytics'])->name('dashboard.analytics')->middleware('auth');


// Products
Route::get('/products' , [ProductController::class , 'index'])->name('products.index')->middleware('auth');


// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index')->middleware('auth'); 


// Clients
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index')->middleware('auth');
Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create')->middleware('auth');
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store')->middleware('auth');
Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show')->middleware('auth');
Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');


// Suppliers
Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index')->middleware('auth');
Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create')->middleware('auth');
Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store')->middleware('auth');
Route::get('/suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show')->middleware('auth');
Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');


// Orders
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware('auth'); 
