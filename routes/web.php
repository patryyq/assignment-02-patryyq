<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\MessageController;

Route::post('/like/{post}', [LikeController::class, 'like'])->middleware('auth');
Route::post('/follower/{user}', [FollowerController::class, 'follow'])->middleware('auth');
Route::get('/explore', [UserController::class, 'explore']);
Route::get('/login', [LoginController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest')->name('authenticate');
Route::post('/login-2fa', [LoginController::class, 'twoFactorAuthenticaton'])->middleware('guest')->name('2fa');
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('registration');
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');
Route::resource('posts', PostController::class)->middleware('auth');
Route::get('/post/{post}', [PostController::class, 'show']);
Route::resource('comment', CommentController::class)->middleware('auth');
Route::get('/', [PostController::class, 'index']);
Route::get('/feed', [PostController::class, 'feed'])->middleware('auth')->name('feed');
Route::get('/user/{user}', [PostController::class, 'userPosts']);
Route::get('/forgot-password', [ForgotPasswordController::class, 'forgot'])->middleware('guest');
Route::get('/reset-password/{email}/{token}', [ForgotPasswordController::class, 'verifyToken'])->middleware('guest');
Route::post('/reset-password/{email}/{token}', [ForgotPasswordController::class, 'resetPassword'])->middleware('guest')->name('new-pw');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendLinkWithToken'])->middleware('guest')->name('forgot-pw');
Route::get('/messages', [MessageController::class, 'viewAll'])->middleware('auth');
Route::get('/messages/{username}', [MessageController::class, 'viewSingle'])->middleware('auth')->name('single-msg');
Route::post('/msg/{username}', [MessageController::class, 'store'])->middleware('auth')->name('send-msg');
Route::post('/msg-read/{username}', [MessageController::class, 'markAsReadJS'])->middleware('auth')->name('mark-as-read');
Route::get('/username/{needle}', [UserController::class, 'findMatchingUsernames'])->middleware('auth');
