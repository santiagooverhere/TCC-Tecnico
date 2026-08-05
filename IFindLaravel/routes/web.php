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
    Route::get('comentarios', [ComentarioController::class, 'index'])->name('comentarios.index');
    Route::get('comentarios/create', [ComentarioController::class, 'create'])->name('comentarios.create');
    Route::post('comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');
    Route::get('comentarios/{users_id}/{post_id}/edit', [ComentarioController::class, 'edit'])->name('comentarios.edit');
    Route::put('comentarios/{users_id}/{post_id}', [ComentarioController::class, 'update'])->name('comentarios.update');
    Route::delete('comentarios/{users_id}/{post_id}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy');
});