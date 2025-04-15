<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HashtagController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Ce fichier contient toutes les routes accessibles via /api/
| Laravel préfixe automatiquement toutes ces routes par /api/
|
*/

// 🔐 Routes d'authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// 🔓 Routes publiques
Route::apiResource('posts', PostController::class)->only(['index', 'show']);
Route::apiResource('users', UserController::class)->only(['index', 'show']);
Route::apiResource('hashtags', HashtagController::class)->only(['index', 'show']);

// 🔐 Routes protégées par auth (ex : Sanctum ou autre middleware)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('comments', CommentController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('likes', LikeController::class)->only(['store', 'destroy']);
    Route::apiResource('follows', FollowController::class)->only(['store', 'destroy']);
    
    // User profile routes
    Route::get('/user', [UserController::class, 'profile']);
    Route::put('/user', [UserController::class, 'update']);
});

// 🧪 Routes utiles supplémentaires (relations, custom endpoints)
Route::get('posts/{post}/hashtags', [PostController::class, 'hashtags']);
Route::get('posts/{post}/comments', [PostController::class, 'comments']);
Route::get('posts/{post}/likes', [PostController::class, 'likes']);
Route::get('hashtags/{hashtag}/posts', [HashtagController::class, 'posts']);
Route::get('users/{user}/followers', [FollowController::class, 'followers']);
Route::get('users/{user}/following', [FollowController::class, 'following']);
Route::get('users/{user}/posts', [PostController::class, 'userPosts']);
