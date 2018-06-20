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
| is assigned the "device" middleware group. Enjoy building your Device!
|
*/

Route::middleware('auth:device')->get('/device', function (Request $request) {
    return $request->user();
});
