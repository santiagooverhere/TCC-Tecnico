<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('/');

Route::get('/login', function () {
    return view('auth.login');
})->name('/login');

Route::get('/cadastro', function () {
    return view('auth.register');
})->name('/register');

Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('/admin');