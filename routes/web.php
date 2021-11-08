<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowerController;


//Route::get('/create-post', [PostController::class, 'create']);
Route::post('/like/{post}', [LikeController::class, 'like'])->middleware('auth');
Route::post('/follower/{user}', [FollowerController::class, 'follow'])->middleware('auth');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');
Route::resource('posts', PostController::class);
Route::get('/post/{post}', [PostController::class, 'show']);
Route::resource('comment', CommentController::class);
Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/user/{user}', [PostController::class, 'userPosts']);
