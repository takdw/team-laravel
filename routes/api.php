<?php

use App\Http\Controllers\TeamPlayerController;
use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('core')->group(function () {
    Route::post('/teams', [TeamController::class, 'store']);
    Route::post('/teams/{team}/players', [TeamPlayerController::class, 'store']);
    Route::post('/teams/{team}/players/{player}/edit', [TeamPlayerController::class, 'update']);
});