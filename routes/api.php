<?php

use Illuminate\Http\Request;
// use Helper;
// use Curl;
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
//

Route::get('/user', function (Request $request) {
	return $request->user();
})->middleware('auth:api');

Route::post('team', 'TeamController@list')->name('team-api');
Route::post('jenis_berkas', 'CategoryController@list')->name('jenis_berkas-api');
Route::post('tag', 'TagController@list')->name('tag-api');

Route::post('sosmed', 'SosmedController@list')->name('sosmed-api');
Route::post('product', 'ProductController@list')->name('product-api');

Route::post('customer', 'CustomerController@list')->name('customer-api');
Route::post('gedung', 'GedungController@list')->name('gedung-api');
Route::post('ruangan', 'RuanganController@list')->name('ruangan-api');
Route::post('rack', 'RackController@list')->name('rack-api');