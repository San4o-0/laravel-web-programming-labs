<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Blog\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['namespace' => 'App\Http\Controllers\Api\Blog', 'prefix' => 'blog'], function () {
    Route::apiResource('posts', PostController::class)->names('blog.posts');
});
