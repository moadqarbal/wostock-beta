<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
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
Route::get('/dashboard/help', [DashboardController::class, 'help'])->name('dashboard.help')->middleware('auth');
Route::get('/dashboard/propose-feature', [DashboardController::class, 'proposeFeature'])->name('dashboard.propose-feature')->middleware('auth');
Route::post('/dashboard/propose-feature', [DashboardController::class, 'sendFeatureProposal'])->name('dashboard.propose-feature.send')->middleware('auth');
Route::get('/dashboard/analytics/export', [DashboardController::class, 'exportAnalytics'])->name('dashboard.analytics.export')->middleware('auth');



// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('auth');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('auth');
Route::get('/products/trashed', [ProductController::class, 'trashed'])->name('products.trashed')->middleware('auth');
Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('auth');
// Special product actions
Route::patch('/products/{product}/restore', [ProductController::class, 'restore'])->name('products.restore')->middleware('auth');
Route::delete('/products/{product}/force-delete', [ProductController::class, 'forceDelete'])->name('products.force-delete')->middleware('auth');
// Dynamic {product} routes 
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show')->middleware('auth');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('auth');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('auth');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('auth');



// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index')->middleware('auth'); 
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create')->middleware('auth');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store')->middleware('auth');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware('auth');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update')->middleware('auth');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('auth');
Route::get('/dashboard/error-404', [DashboardController::class, 'error404'])->name('dashboard.error-404');
Route::get('/dashboard/error-500', [DashboardController::class, 'error500'])->name('dashboard.error-500');


// Clients
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index')->middleware('auth');
Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create')->middleware('auth');
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store')->middleware('auth');
Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show')->middleware('auth');
Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit')->middleware('auth');
Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update')->middleware('auth');
Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy')->middleware('auth');



// Suppliers
Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index')->middleware('auth');
Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create')->middleware('auth');
Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store')->middleware('auth');
Route::get('/suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show')->middleware('auth');
Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit')->middleware('auth');
Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update')->middleware('auth');
Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy')->middleware('auth');


// Orders
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware('auth'); 
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create')->middleware('auth');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store')->middleware('auth');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show')->middleware('auth');
// Special product actions
Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status')->middleware('auth');
// Dynamic {product} routes 
Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit')->middleware('auth');
Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update')->middleware('auth');
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy')->middleware('auth');


// Profiles
Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('dashboard.edit')->middleware('auth');
Route::put('/dashboard/profile', [ProfileController::class, 'updateProfile'])->name('dashboard.profile.update')->middleware('auth');
Route::put('/dashboard/password', [ProfileController::class, 'updatePassword'])->name('dashboard.password.update')->middleware('auth');


