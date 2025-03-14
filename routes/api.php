<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('posts', [PostController::class, 'index']);
Route::post('posts/create', [PostController::class, 'store']);
Route::put('posts/edit/{post}', [PostController::class, 'update']);
Route::delete('posts/{post}', [PostController::class, 'delete']);

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

