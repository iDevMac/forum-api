<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Feed\FeedController;
use Illuminate\Http\Request;
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





    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');

    Route::middleware('auth:sanctum')->group(function () {
       Route::get('dash', [AuthController::class, 'dashboard'])->name('dash');
       Route::get('feeds', [FeedController::class, 'index']);
       Route::post('feed/store', [FeedController::class, 'store']);
       Route::post('feed/like/{feed_id}', [FeedController::class, 'likePost']);
       Route::get('feed/comments/{feed_id}', [FeedController::class, 'getComments']);
       Route::post('feed/comment/store/{feed_id}', [FeedController::class, 'comment']);
    });


