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

Route::group(['prefix' => 'v1'], function(){
	Route::get('provinsi', 'ApiMasterController@provinsi');
	Route::get('kota', 'ApiMasterController@kota');
	Route::get('bidang', 'ApiMasterController@bidang');
	Route::get('sub_bidang', 'ApiMasterController@bidang_sub');
	Route::get('badan_usaha', 'ApiMasterController@badan_usaha');
	Route::get('jenis_usaha', 'ApiMasterController@jenis_usaha');
	Route::group(['prefix' => 'users'], function(){
		Route::get('', 'UserController@getData');
	});
	Route::group(['prefix' => 'tasks'], function(){
		Route::post('aprove/{id}', 'TaskController@aprove');
		Route::post('cancel/{id}', 'TaskController@cancel');
	});
});
