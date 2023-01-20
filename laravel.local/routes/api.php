<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/auth/me', [AuthController::class, 'showUser']);
Route::middleware('auth:sanctum')->get('/auth/me/activity', [UserController::class, 'showUserActivity']);
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('/auth/logout', [AuthController::class, 'logoutUser']);
Route::middleware('auth:sanctum')->post('/auth/changeData', [AuthController::class, 'changeUserData']);
Route::middleware('auth:sanctum')->get('posts/{id}/like', [UserController::class, 'likePost']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'posts' => PostController::class,
        'posts/{id}' => PostController::class,
        'categories' => CategoryController::class,
    ]);
});


