<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home','UserController@index');
Route::get('/upload/file','UserController@uploadFile')->name('upload.file');
Route::post('/store','UserController@store')->name('store');
Route::get('/circle','UserController@circle')->name('circle');
Route::get('/coordinate','UserController@coordinate')->name('coordinate');
Route::get('/bar','UserController@bar')->name('bar');
