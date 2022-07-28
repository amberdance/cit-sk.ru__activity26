<?php

use Illuminate\Support\Facades\Route;

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
    Route::get('/districts', [\App\Http\Controllers\RegistrationController::class, 'districts']);
    Route::get('/reset-code', [\App\Http\Controllers\RegistrationController::class, 'resetCode']);
    Route::get('/verify-code', [\App\Http\Controllers\RegistrationController::class, 'verifyCode']);
});

/*
|--------------------------------------------------------------------------
| POLLS
|--------------------------------------------------------------------------
 */
Route::post('/polls/vote', [\App\Http\Controllers\PollController::class, 'vote'])->middleware('auth:api');
Route::get('/polls/{id}/result', [\App\Http\Controllers\PollController::class, 'results'])->middleware('auth:api');

Route::apiResources([
    'polls' => \App\Http\Controllers\PollController::class,
]);

/*
|--------------------------------------------------------------------------
| PAGES
|--------------------------------------------------------------------------
 */
Route::group(['prefix' => 'pages'], function () {
    Route::get('/main/counters', [\App\Http\Controllers\MainPageController::class, 'getCounters']);
    Route::get('/main/news', [\App\Http\Controllers\MainPageController::class, 'getNews']);
});
