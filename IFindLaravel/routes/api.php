<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ComentarioApiController;
use App\Http\Controllers\Api\PostApiController;
use Illuminate\Support\Facades\Route;

// Login público
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/me', [AuthApiController::class, 'me']);

    Route::get('/posts', [PostApiController::class, 'index']);
    Route::post('/posts', [PostApiController::class, 'store']);
    Route::get('/posts/{post}', [PostApiController::class, 'show']);

    Route::match(['put', 'post'], '/posts/{post}', [PostApiController::class, 'update']);
    Route::delete('/posts/{post}', [PostApiController::class, 'destroy']);
    Route::patch('/posts/{post}/resolver', [PostApiController::class, 'resolver']);

    Route::get('/posts/{post}/comentarios', [ComentarioApiController::class, 'index']);
    Route::post('/posts/{post}/comentarios', [ComentarioApiController::class, 'store']);
    Route::delete('/comentarios/{comentario}', [ComentarioApiController::class, 'destroy']);
});
