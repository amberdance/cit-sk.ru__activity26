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

Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);
Route::post('/auth/login', [\App\Http\Controllers\UserController::class, 'login']);
// Route::get('/users/me', function () {
//     return auth()->user();
// });

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/users/me', function () {
        return auth()->user();
    });

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
