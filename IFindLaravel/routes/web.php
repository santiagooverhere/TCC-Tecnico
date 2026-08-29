<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//rotas site
Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/cadastro', [AuthController::class, 'register'])->name('register');

//admin e CRUD
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    //CRUD de Posts
    Route::resource('posts', PostController::class);

    //CRUD de Users
    Route::resource('users', UserController::class);

    //CRUD de Comentários
    Route::resource('comentarios', ComentarioController::class)->except(['show']);

    //marcar post como devolvido)
    Route::patch('posts/{post}/resolver', [PostController::class, 'resolver'])->name('posts.resolver');
});

//logout do dashboard admin
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');