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
	Route::get('', 'HomeController@index');

	Route::group(['middleware' => 'auth.input.provinsi'], function(){

		Route::resources(['file_manager' => 'FileManagerController']);

		Route::resources(['pemohon' => 'PemohonController']);

		Route::resources(['siki_personal' => 'SikiPersonalController']);
		Route::get('siki_personal/{id}/plain', 'SikiPersonalController@plain');
		Route::get('siki_personal/{id}/sync', 'SikiPersonalController@sync');
		Route::get('siki_personal/{id}/proyek', 'SikiPersonalController@proyek');
		Route::get('siki_personal/{id}/pendidikan', 'SikiPersonalController@pendidikan');
		Route::get('siki_personal/{id}/pendidikan', 'SikiPersonalController@pendidikan');

		Route::get('siki_pendidikan/{id}/sync', 'SikiPendidikanController@sync');

		Route::get('siki_proyek/{id}/sync', 'SikiProyekController@sync');

		Route::resources(['siki_regta' => 'SikiRegtaController']);
		Route::get('siki_regta/{id}/sync', 'SikiRegtaController@sync');
		Route::get('siki_regta/{id}/approve', 'SikiRegtaController@approve');

		Route::resources(['siki_regtt' => 'SikiRegttController']);
		Route::get('siki_regtt/{id}/sync', 'SikiRegttController@sync');
		Route::get('siki_regtt/{id}/approve', 'SikiRegttController@approve');
	});

	Route::group(['middleware' => 'auth.approval'], function(){
		Route::resources(['approval_report' => 'ApprovalController']);
		Route::get('approval_detail', 'ApprovalController@detail');

		Route::resources(['approval_regta' => 'ApprovalRegtaController']);
		Route::get('approval_regta/{id}/approve', 'ApprovalRegtaController@approve');

		Route::resources(['approval_regtt' => 'ApprovalRegttController']);
		Route::get('approval_regtt/{id}/approve', 'ApprovalRegttController@approve');

		Route::resources(['team_kontribusi_ta' => 'TeamKontribusiTAController']);

		Route::resources(['team_kontribusi_tt' => 'TeamKontribusiTTController']);

		Route::resources(['approval_99' => 'Approval99Controller']);
		Route::get('approval_99/{id}/approve', 'Approval99Controller@approve');
	});

	Route::group(['middleware' => 'auth.admin'], function(){
		Route::resources(['users' => 'UserController']);
	});
	
});