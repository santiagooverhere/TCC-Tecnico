<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


Route::get('/', 
[AuthController::class, 'dashboard'])->name('dashboard');

Route::get('/login', 
[AuthController::class, 'login'])->name('login');

Route::get('/cadastro', 
[AuthController::class, 'register'])->name('register');

Route::get('/admin', 
[AdminController::class, 'index'])->name('admin.dashboard');