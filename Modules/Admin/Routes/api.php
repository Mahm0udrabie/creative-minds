<?php

use Illuminate\Http\Request;
use Modules\Admin\Http\Controllers\Auth\AuthAdminController;
use Modules\Admin\Http\Controllers\AdminController;

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

Route::middleware('auth:api')->get('/admin', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'json', 'prefix' => 'admin'], function () {

    Route::post('/login', [AuthAdminController::class, 'login']);

    Route::group(['middleware' => ['jwt-admin-verify']], function () {

        Route::post('logout', [AuthAdminController::class, 'logout']);

        Route::group(['prefix' => 'operations'], function () {

            Route::controller('AdminController')->group(function () {

                Route::get('index', 'index');

                Route::post('store', 'store');

                Route::get('show/{id}', 'show');

                Route::put('update/{id}', 'update');

                Route::delete('destroy/{id}', 'destroy');
            });
        });
    });
});
