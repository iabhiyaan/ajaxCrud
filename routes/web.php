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

Route::get('/', function () {
    return view('welcome');
});


Route::resource('ajax','admin\AjaxControler');
Route::post('delete','admin\AjaxControler@delete');
Route::post('update','admin\AjaxControler@aupdate');
Route::get('search','admin\AjaxControler@search')->name('search');