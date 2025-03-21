<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/

Route::get('/posts', [\App\Http\Controllers\PostController::class, 'index']);
Route::get('/posts/{id}', [\App\Http\Controllers\PostController::class, 'show']);
Route::post("/posts", [\App\Http\Controllers\PostController::class, 'store']);
Route::put("/posts/{id}", [\App\Http\Controllers\PostController::class, 'update']);
Route::delete("/posts/{id}", [\App\Http\Controllers\PostController::class, 'destroy']);
