<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\JsonResponse;

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

Route::middleware('auth:sanctum')->get('/auth/me', function (Request $request): JsonResponse {
    $user = $request->user();
    return response()->json([
        'name' => $user->name,
        'surname' => $user->surname,
        'login' => $user->login,
    ]);
});
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('/auth/logout', [AuthController::class, 'logoutUser']);
Route::post('/auth/changeData', [AuthController::class, 'changeUserData']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'posts' => PostController::class,
        'posts/{id}' => PostController::class,
    ]);
});


