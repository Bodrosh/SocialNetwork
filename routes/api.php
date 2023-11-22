<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PostImageController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);

    Route::post('/post_images', [PostImageController::class, 'store']);
    Route::post('/posts/{post}/toggle_like', [PostController::class, 'toggleLike']);
    Route::post('/posts/{post}/repost', [PostController::class, 'repost']);
    Route::get('/posts/{post}/comment', [PostController::class, 'commentList']);
    Route::post('/posts/{post}/comment', [PostController::class, 'comment']);
    Route::post('/posts/by_tag', [PostController::class, 'getByTag']);

    Route::post('/comments/by_tag', [CommentController::class, 'getByTag']);

    Route::get('/users/{user}/posts', [UserController::class, 'posts']);
    Route::post('/users/{user}/toggle_following', [UserController::class, 'toggleFollowing']);

    Route::post('/users/stats', [UserController::class, 'stat']);
});
