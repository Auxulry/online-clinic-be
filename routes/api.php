<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\QueueController;
use Illuminate\Http\Request;
USE App\Http\Controllers\API\PoliController;
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

Route::prefix('authentication')->namespace('API')->group(function () {
    Route::post('login', [AuthenticationController::class, 'login']);
    Route::post('register', [AuthenticationController::class, 'register']);
    Route::middleware('auth:api')->get('me', [AuthenticationController::class, 'me']);
});

Route::get('polis', [PoliController::class, 'index']);
Route::middleware('auth:api')->post('queue', [QueueController::class, 'createQueue']);
Route::middleware('auth:api')->get('queue', [QueueController::class, 'getQueue']);
Route::middleware('auth:api')->post('polis', [PoliController::class, 'create']);

