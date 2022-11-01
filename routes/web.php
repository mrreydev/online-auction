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

// Route::get('/', function () {
//     return view('welcome');
// });

/* Untuk Masyarakat */
    // Auth
Route::get('/', 			'MasyarakatController@index');
Route::post('/login',       'MasyarakatController@login');
Route::get('/register',     'MasyarakatController@userRegister');
Route::post('/register', 	'MasyarakatController@doRegister');
Route::get('/logout',       'MasyarakatController@logout');

    // Main
Route::get('/beranda',                      'LelangController@mainMenuCli');
Route::get('/lelang',                       'LelangController@allLelangCli');
Route::post('/lelang/filter/{filter_name}',  'LelangController@filterLelang');
Route::get('/lelang/bidding/{id}',          'LelangController@viewBid');
Route::post('/lelang/bidding/{id}',         'LelangController@bidProcess');
Route::get('/riwayat',                      'LelangController@riwayatLelang');

Route::get('/dateTest',     'PetugasController@dateTest');
/* Untuk Admin dan Petugas */
Route::group(['prefix' => 'petugas'], function () {
    Route::get('/login',      'PetugasController@index');
    Route::post('/login',     'PetugasController@login');
    Route::get('/logout',     'PetugasController@logout');

    // Barang
    Route::get('/dashboard',                                    'PetugasController@dashboard');
    Route::get('/barang',                                       'PetugasController@barang');
    Route::post('/barang/post',                                 'PetugasController@storeBarang');
    Route::get('/barang/{id}',                                  'PetugasController@forAjaxBarang');
    Route::get('/barang/delete/{id}',                           'PetugasController@deleteBarang');
    Route::get('/barang/update/{id}',                           'PetugasController@viewUpdateBarang');
    Route::post('/barang/update/{id}',                          'BarangController@editOneDataBarang');
    Route::post('/barang/gambar/edit/{id}',                     'FotoBarangController@editOneFotoBarang');
    Route::get('/barang/delete/{id}',                           'BarangController@deleteBarangCord');
    Route::get('/barang/gambar/deletes/{id}/{namaGambar}',      'FotoBarangController@deleteOneFotoBarang');

    // Petugas
    Route::get('/manage-petugas',               'PetugasController@viewPetugas');
    Route::get('/manage-petugas/{id}',          'PetugasController@viewOnePetugas');
    Route::post('/manage-petugas/post',         'PetugasController@storePetugas');
    Route::post('/manage-petugas/update/{id}',  'PetugasController@updatePetugas');
    Route::get('/manage-petugas/delete/{id}',   'PetugasController@deletePetugas');

    // Lelang
    Route::get('/lelang',                       'LelangController@allLelang');
    Route::get('/lelang/post-view',             'LelangController@viewInsertLelang');
    Route::post('/lelang/post',                 'LelangController@storeLelang');
    Route::get('/lelang/{id}',                  'LelangController@forAjaxLelang');
    Route::get('/lelang/buka-lelang/{id}',      'LelangController@bukaLelang');
    Route::get('/lelang/tutup-lelang/{id}',     'LelangController@tutupLelang');
    Route::post('/lelang/export',                'LelangController@exportLelang');
});

Route::get('*', function(){
    return view('404-page');
});
