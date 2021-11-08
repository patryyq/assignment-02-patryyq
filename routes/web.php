<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;


Route::get('/create-post', [PostController::class, 'create']);
Route::post('/like/{post}', [LikeController::class, 'like'])->middleware('auth');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');
Route::resource('/posts', PostController::class);
Route::resource('/post', PostController::class);
Route::resource('/comment', CommentController::class);
Route::resource('/', PostController::class);
Route::resource('/user/{nickname}', PostController::class);
