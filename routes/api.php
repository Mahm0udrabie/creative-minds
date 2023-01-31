<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['json'])->group(function() {

    Route::controller(AuthController::class)->group(function() {

        Route::post('/register', 'register');

        Route::post('/login', 'login')->middleware('phone-verified');

        Route::post('/verify-phone-number', 'verify');

        Route::post('/resend-code', 'resend');

        Route::post('logout', 'logout')->middleware('jwt-verify');

    });

    Route::middleware(['jwt-verify'])->group(function() {

        Route::controller(UserController::class)->group(function() {

            Route::get('profile', 'profile');

        });

    });

});


