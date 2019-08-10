<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::auth();

Route::group(['middleware' => 'auth'], function(){

	Route::group(['middleware' => 'auth.input'], function(){
		Route::get('', 'HomeController@index');

		Route::resources([
		    'file_manager' => 'FileManagerController',
		]);

		Route::resources([
		    'pemohon' => 'PemohonController',
		]);

		Route::group(['prefix' => 'siki_personal'] , function(){
			Route::get('{id}/plain', 'SikiPersonalController@plain');
			Route::get('{id}/sync', 'SikiPersonalController@sync');
			Route::get('{id}/proyek', 'SikiPersonalController@proyek');
			Route::get('{id}/pendidikan', 'SikiPersonalController@pendidikan');
			Route::get('{id}/pendidikan', 'SikiPersonalController@pendidikan');
		});

		Route::resources([
		    'siki_personal' => 'SikiPersonalController',
		]);

		Route::group(['prefix' => 'siki_pendidikan'] , function(){
			Route::get('{id}/sync', 'SikiPendidikanController@sync');
		});

		Route::group(['prefix' => 'siki_proyek'] , function(){
			Route::get('{id}/sync', 'SikiProyekController@sync');
		});

		Route::group(['prefix' => 'siki_regta'] , function(){
			Route::get('{id}/sync', 'SikiRegtaController@sync');
			Route::get('{id}/approve', 'SikiRegtaController@approve');
		});

		Route::resources([
		    'siki_regta' => 'SikiRegtaController',
		]);

		Route::group(['prefix' => 'siki_regtt'] , function(){
			Route::get('{id}/sync', 'SikiRegttController@sync');
			Route::get('{id}/approve', 'SikiRegttController@approve');
		});

		Route::resources([
		    'siki_regtt' => 'SikiRegttController',
		]);
	});

	Route::group(['middleware' => 'auth.admin'], function(){
		Route::resources([
		    'users' => 'UserController',
		]);
	});
	
});