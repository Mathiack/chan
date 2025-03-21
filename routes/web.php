<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', [\App\Http\Controllers\PostController::class, 'index']);
Route::get('/posts/{id}', [\App\Http\Controllers\PostController::class, 'show']);
Route::post("/posts", [\App\Http\Controllers\PostController::class, 'store']);
