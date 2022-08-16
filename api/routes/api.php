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

Route::group(['prefix' => 'users'],
    function () {
        Route::post('/', [\App\Http\Controllers\UserController::class, 'store']);
        Route::post('/password-reset', [\App\Http\Controllers\UserController::class, 'resetPassword']);
        Route::get('/districts', [\App\Http\Controllers\UserController::class, 'districts']);
        Route::get('/recovery', [\App\Http\Controllers\UserController::class, 'recovery']);
    });

/*
|--------------------------------------------------------------------------
| REGISTRATION
|--------------------------------------------------------------------------
 */
Route::prefix('sms')->group(function () {
    Route::get('/verify-code', [\App\Http\Controllers\SmsController::class, 'verifyCode']);
    Route::get('/reset-code', [\App\Http\Controllers\SmsController::class, 'resetCode']);
});

/*
|--------------------------------------------------------------------------
| POLLS
|--------------------------------------------------------------------------
 */
Route::post('/polls/vote', [\App\Http\Controllers\PollController::class, 'vote'])->middleware('auth:api');
Route::get('/polls/{id}/result', [\App\Http\Controllers\PollController::class, 'results']);

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

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
 */

Route::group(['middleware' => ['auth:api', 'admin']],
    function () {
        Route::post('/users/delete', [\App\Http\Controllers\UserController::class, 'delete']);
        Route::post('/users/associate', [\App\Http\Controllers\UserController::class, 'associate']);
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
        Route::get('/users/{id}', [\App\Http\Controllers\UserController::class, 'show']);
        Route::get('/users/transfer', [\App\Http\Controllers\UserController::class, 'transferUser']);
        Route::get('/admin/dashboard', [\App\Http\Controllers\CmsController::class, 'dashboard']);
    });
