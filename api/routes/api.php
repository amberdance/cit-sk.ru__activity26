<?php

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

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
 */

Route::post('/auth/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::group([
    'middleware' => ['auth:api'],
    'prefix'     => 'auth',
],
    function () {
        Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
        Route::post('/refresh', [\App\Http\Controllers\AuthController::class, 'refreshToken']);
        Route::get('/me', [\App\Http\Controllers\AuthController::class, 'me']);
    });

/*
|--------------------------------------------------------------------------
| USERS
|--------------------------------------------------------------------------
 */

/*
|--------------------------------------------------------------------------
| RESOURCE API-ROUTES
|--------------------------------------------------------------------------
 */

Route::apiResources([
    'polls' => \App\Http\Controllers\PollController::class,
]);
