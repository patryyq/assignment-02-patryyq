<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LikeController;

Route::resource('/', PostController::class);
Route::resource('/posts', PostController::class);
Route::get('post/{post}/like', [LikeController::class, 'like'])->middleware('auth');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');
