<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Users
Route::get('/register' , [UserController::class , 'create'])->name('users.create');
Route::post('/users' , [UserController::class , 'store'])->name('users.store');