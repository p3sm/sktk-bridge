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
	Route::resources(['file_manager' => 'FileManagerController']);
	Route::resources(['pemohon' => 'PemohonController']);

	Route::group(['middleware' => 'authorization:upsiki'], function () {
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

	Route::group(['middleware' => 'authorization:status_99'], function () {

		Route::resources(['approval_regta' => 'ApprovalRegtaController']);
		Route::get('approval_regta/{id}/approve', 'ApprovalRegtaController@approve');

		Route::resources(['approval_regtt' => 'ApprovalRegttController']);
		Route::get('approval_regtt/{id}/approve', 'ApprovalRegttController@approve');

		Route::resources(['approval_99' => 'Approval99Controller']);
		Route::get('approval_99/{id}/approve', 'Approval99Controller@approve');

		Route::resources(['hapus_99' => 'Hapus99Controller']);
		Route::get('hapus_99/{id}/approve', 'Hapus99Controller@approve');
	});

	Route::group(['middleware' => 'authorization:team'], function () {

		Route::resources(['team_kontribusi_ta' => 'TeamKontribusiTAController']);

		Route::resources(['team_kontribusi_tt' => 'TeamKontribusiTTController']);

		Route::resources(['produksi' => 'ProduksiController']);

		Route::resources(['gol_harga_produksi' => 'ProduksiGolHargaController']);

		Route::resources(['marketing' => 'MarketingController']);

		Route::resources(['gol_harga_marketing' => 'MarketingGolHargaController']);
		
		Route::get('gol_harga_marketing_head', 'MarketingGolHargaController@createHead');
		Route::post('gol_harga_marketing_head', 'MarketingGolHargaController@storeHead');
	});

	Route::group(['middleware' => 'authorization:report'], function () {
		Route::resources(['approval_report' => 'ApprovalController']);
		Route::get('approval_detail', 'ApprovalController@detail');
		Route::resources(['laporan' => 'LaporanController']);
	});

	Route::group(['middleware' => 'authorization:user'], function () {
		Route::resources(['users' => 'UserController']);
	});

	Route::group(['middleware' => 'authorization:master'], function () {
		Route::resources(['master_badanusaha' => 'BadanUsahaController']);
		Route::resources(['master_pjklpjk' => 'PjkLpjkController']);
	});
	
});