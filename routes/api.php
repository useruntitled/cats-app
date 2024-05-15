<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\Auth\AuthController::class)->group(function () {
   Route::post('/register', 'register');
   Route::post('/login', 'login');
   Route::post('/refresh', 'refresh')->middleware('auth:api');
   Route::post('/me', 'me')->middleware('auth:api');
});

Route::controller(\App\Http\Controllers\PostController::class)->group(function () {
   Route::get('/posts/latest', 'latest')->name('posts.latest');
});

Route::controller(\App\Http\Controllers\ProfileController::class)->group(function () {
   Route::get('/users/{id?}', 'index')->name('users.view');
   Route::post('/users/{id}/avatar', 'storeAvatar')->name('users.avatar.store');
});
