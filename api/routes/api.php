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
Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);
Route::get('/users/{id}', [\App\Http\Controllers\UserController::class, 'getUser']);

/*
|--------------------------------------------------------------------------
| REGISTRATION
|--------------------------------------------------------------------------
 */

Route::prefix('registration')->group(function () {
    Route::get('/reset-code', [\App\Http\Controllers\RegistrationController::class, 'resetCode']);
    Route::get('/verify-code', [\App\Http\Controllers\RegistrationController::class, 'verifyCode']);
});
