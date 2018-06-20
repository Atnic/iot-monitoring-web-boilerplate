<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Device Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Device routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api_device" middleware group. Enjoy building your Device!
|
*/

Route::post('login', 'ApiDevice\Auth\LoginController@login')->name('api.device.login');
Route::post('logout', 'ApiDevice\Auth\LoginController@logout')->name('api.device.logout');
Route::post('register', 'ApiDevice\Auth\RegisterController@register')->name('api.device.register');

Route::middleware('auth:api_device')->get('/device', function (Request $request) {
    return $request->user();
});
Route::apiResource('device_logs', 'ApiDevice\DeviceLogController', [ 'as' => 'api.device' ]);
Route::apiResource('data', 'ApiDevice\DatumController', [ 'as' => 'api.device' ]);
