<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Routes Naming Convention
|--------------------------------------------------------------------------
| Biar teratur, ada peraturan untuk penamaan Route
|
| /{ TABEL/DATA }/{ AKSI }/{ PARAMS }
|
| atau....
|
| /{ TABEL/DATA }/{ SERVICE }/{ KET }/{ PARAMS }/{ PARAMS }
|
| Uppercase semua, Menggunakan Pemisah "_"
|
*/

Route::group(['prefix' => 'API'], function() {

  Route::post('/USER/LOGIN', 'UserController@login');

  Route::get('/TOKEN/REFRESH', 'ServicesController@refreshToken');

  Route::get('/TIME', 'ServicesController@getTime');
  Route::get('/TIME/FULL', 'ServicesController@getFullTime');

  Route::get('/DATE', 'ServicesController@getTgl');

  Route::get('/PERUM/ALL', 'PerumController@perumAll');

  Route::get('/RUMAH/GET', 'RumahController@get');
  Route::get('/RUMAH/GET/BY_ID/{id}', 'RumahController@getById');
  Route::get('/RUMAH/GET/BY_PERUM/ID/{id}', 'RumahController@getByPerumId');
  Route::get('/RUMAH/GET/BY_PERUM/ID/{id}/TERSEDIA', 'RumahController@tersediaByPerumId');


  // ----------[ Secure API ]--------
  Route::group(['middleware' => ['JWTCheck']], function () {

    Route::get('/USER/LOGGED', 'UserController@logged');
    Route::get('/USER/GET/ONE/BY_BIRO/{biro}', 'UserController@getOneByBiro');

    Route::get('/NOTIFIER', 'NotifController@polling');
    Route::post('/NOTIFIER/DELETE', 'NotifController@deleteNotifier');

    Route::post('/NOTIF/ADD', 'NotifController@addNotif');
    Route::get('/NOTIF/GET', 'NotifController@get');
    Route::post('/NOTIF/GET/FROM_POLLING', 'NotifController@getFromPolling');
    Route::post('/NOTIF/READ', 'NotifController@read');

    Route::post('/ABSENT/TODAY', 'AbsenController@absenHariIni');
    Route::post('/ABSENT/ADD', 'AbsenController@absen');

    Route::post('/PERUM/ADD', 'PerumController@newPerum');
    Route::post('/PERUM/EDIT', 'PerumController@edit');
    Route::post('/PERUM/DELETE', 'PerumController@delete');

    Route::post('/RUMAH/ADD', 'RumahController@newRumah');
    Route::post('/RUMAH/EDIT', 'RumahController@edit');
    Route::post('/RUMAH/DELETE', 'RumahController@delete');

    Route::post('/KLIEN/ADD', 'KlienController@newKlien');
    Route::get('/KLIEN/GET', 'KlienController@getKlien');
    Route::get('/KLIEN/GET/BY_ID/{id}', 'KlienController@getKlienById');
    Route::get('/KLIEN/GET/BAYAR/{tipe}/BY_ID/{id}', 'KlienController@getKlienBayarById');
    Route::get('/KLIEN/GET/HAS_RUMAH/{id}', 'KlienController@getKlienHasRumah');
    Route::post('/KLIEN/EDIT', 'KlienController@editKlien');
    Route::post('/KLIEN/DELETE', 'KlienController@deleteKlien');
    Route::get('/KLIEN/SEARCH/ALL', 'KlienController@searchKlien');
    Route::get('/KLIEN/SEARCH/MINIMAL', 'KlienController@searchKlienMinimal');
    Route::get('/KLIEN/SEARCH/BAYAR/{tipe}', 'KlienController@searchKlienBayar');
    Route::get('/KLIEN/{tipe}/SEARCH/MINIMAL', 'KlienController@searchKlienSpesificMinimal');
    Route::get('/KLIEN/KPR/GET/', 'KlienController@getKlienKPR');
    Route::post('/KLIEN/BELI_RUMAH_BARU/', 'KlienController@beliRumahBaru');
    Route::post('/KLIEN/EDIT_RUMAH_KLIEN/', 'KlienController@editRumahKlien');
    Route::post('/KLIEN/DELETE_RUMAH_KLIEN/', 'KlienController@deleteRumahKlien');

    Route::post('/BAYAR/{tipe}', 'BayarController@bayar');
    Route::post('/TERBAYAR/EDIT', 'BayarController@edit');
    Route::post('/TERBAYAR/DELETE', 'BayarController@delete');
    Route::get('/TERBAYAR/BY_KLIEN_ID/{klien_id}/BY_RUMAH_KLIEN_ID/{rumah_klien_id}', 'BayarController@getTerbayarByKlienIdAndRumahKlienId');
    Route::get('/TERBAYAR/NO_KPR/BY_KLIEN_ID/{klien_id}/BY_RUMAH_KLIEN_ID/{rumah_klien_id}', 'BayarController@getTerbayarByKlienIdAndRumahKlienIdNoKPR');
    Route::get('/TERBAYAR/KPR/BY_KLIEN_ID/{klien_id}/BY_RUMAH_KLIEN_ID/{rumah_klien_id}', 'BayarController@getTerbayarByKlienIdAndRumahKlienIdKPROnly');

    Route::get('/CETAK/GET', 'CetakController@get');
    Route::post('/CETAK/VALIDASI', 'CetakController@validasiCetak');
    Route::post('/CETAK/VALIDASI/EDIT', 'CetakController@editValidasiCetak');
    Route::get('/CETAK/VALIDASI/GET/BY_ID/{id}', 'CetakController@getValidasiCetak');
  });


});

Route::group(['prefix' => 'PDF'], function(){

  Route::get('/PERJANJIAN/PENGIKATAN_JUAL_BELI', 'PDFController@perjanjianPengikatanJualBeli');

  // Route::get('/KUITANSI/ADD', 'PDFController@kuitansiK2');

  Route::get('/VIEWER', 'PDFController@viewOnly');
  Route::get('/VIEWERP', 'PDFController@viewPrintable');

  Route::group(['middleware' => ['PDFJWTCheck']], function () {
    Route::get('/GET/{dir}/{name}', 'PDFController@get');
  });

  Route::group(['middleware' => ['JWTCheck']], function () {
    Route::post('/ADD/{tipe}', 'PDFController@cetakBaru');
  });
});

Route::get('/', function () {
  return view('welcome');
});

Route::get('/encrypt', function () {
  $id = 1;
  return print_r($id);
});

Route::get('/info', function () {
  return phpinfo();
});

Route::get('/tes', function () {
  $dir = \Storage::exists('pdf/kuitansi');
  if(! $dir ) \Storage::makeDirectory('pdf/kuitansi');
  return var_dump($dir);
});

Route::get('/pdf', function () {
  $pdf = PDF::loadView('cetak/pesan-baru')->setPaper('a4');
  return $pdf->stream();
});


Route::get('/file', function () {
  return asset('public/react-js.pdf');
  // return Storage::files('/');
  // return Storage::get('react-js.pdf');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
