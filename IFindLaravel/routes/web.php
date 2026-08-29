<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//rotas site
Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');

//admin e CRUD
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    //CRUD de Posts
    Route::resource('posts', PostController::class)->only(['store', 'show', 'update', 'destroy']);

    //CRUD de Users
    Route::resource('users', UserController::class)->only(['store', 'show', 'update', 'destroy']);

    //CRUD de Comentários
    Route::resource('comentarios', ComentarioController::class)->only(['store', 'update', 'destroy']);

    //marcar post como devolvido
    Route::patch('posts/{post}/resolver', [PostController::class, 'resolver'])->name('posts.resolver');
});