<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\Auth\AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/refresh', 'refresh')->middleware('auth:api');
    Route::post('/me', 'me')->middleware('auth:api');
});

Route::controller(\App\Http\Controllers\PostController::class)->group(function () {
    Route::get('/posts/', 'get')->name('posts');
    Route::get('/posts/{id}', 'index')->name('posts.view');
    Route::post('/posts', 'store')->name('posts.store')->middleware('auth:api');
    Route::put('/posts/publish', 'publish')->name('posts.publish')->middleware('auth:api');
});

Route::controller(\App\Http\Controllers\ProfileController::class)->group(function () {
    Route::get('/users/{id?}', 'index')->name('users.view');
    Route::post('/me/avatar', 'storeAvatar')->name('users.avatar.store')->middleware('auth:api');

});

Route::controller(\App\Http\Controllers\MediaController::class)->group(function () {
    Route::post('/media', 'store')->name('media.store')->middleware('auth:api');
    Route::get('/media/{uuid}/{format?}', 'index')->name('media.view');
    Route::delete('/me/avatar', 'destroy')->name('users.avatar.delete')->middleware('auth:api');
});

Route::controller(\App\Http\Controllers\CommentController::class)->group(function () {
    Route::get('/comments', 'get')->name('comments');
    Route::post('/comments', 'store')->name('comments.store')->middleware('auth:api');
});
