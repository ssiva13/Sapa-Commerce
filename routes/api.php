<?php

use Illuminate\Http\Request;

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
Route::any('/handle-result', 'MpesaController@handle_result')->name('handle_result_api');
Route::any('/receive-reversal', 'MpesaController@receive_reversal')->name('receive_reversal');
Route::post('/queue-timeout', 'MpesaController@queue_timeout')->name('queue_timeout_api');