<?php

use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/links', [LinkController::class, 'index']);
Route::middleware('auth:sanctum')->get('/links/{id}', [LinkController::class, 'show']);
Route::middleware('auth:sanctum')->get('/favoriteLinks', [LinkController::class, 'indexFavorites']);
Route::middleware('auth:sanctum')->post('/links/{link}/like', [LikeController::class, 'store']);
Route::middleware('auth:sanctum')->get('/followers', [FollowController::class, 'index']);
Route::middleware('auth:sanctum')->post('/follow', [FollowController::class, 'followByEmail']);




