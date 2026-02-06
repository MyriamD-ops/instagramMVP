<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Routes pour l'API REST de l'application Instagram MVP
|
*/

// Routes d'authentification (non protégées)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées par authentification
Route::middleware('auth:sanctum')->group(function () {
    
    // Authentification
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Posts
    Route::get('/feed', [PostController::class, 'index']); // Feed personnel
    Route::get('/users/{userId}/posts', [PostController::class, 'userPosts']); // Posts d'un utilisateur
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
    
    // Likes
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle']);
    
    // Commentaires
    Route::get('/posts/{post}/comments', [CommentController::class, 'index']);
    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
    Route::delete('/posts/{post}/comments/{comment}', [CommentController::class, 'destroy']);
    
    // Follows
    Route::post('/users/{user}/follow', [FollowController::class, 'toggle']);
    Route::get('/users/{user}/followers', [FollowController::class, 'followers']);
    Route::get('/users/{user}/following', [FollowController::class, 'following']);
    
    // Utilisateurs
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::patch('/users/profile', [UserController::class, 'update']);
    Route::get('/search', [UserController::class, 'search']);
    
    // Conversations et messages
    Route::get('/conversations', [ConversationController::class, 'index']);
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show']);
    Route::get('/conversations/with/{user}', [ConversationController::class, 'getOrCreate']);
    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store']);
});

