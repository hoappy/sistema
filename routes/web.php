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
    return view('contenido/contenido');
});

Route::get('/cdc', 'CdcController@index');
Route::post('/cdc/registrar', 'CdcController@store');
Route::put('/cdc/actualizar', 'CdcController@update');
Route::put('/cdc/desactivar', 'CdcController@desactivar');
Route::put('/cdc/activar', 'CdcController@activar');
Route::get('/cdc/selectCdc', 'CdcController@selectCdc');

Route::get('/mutual', 'MutualController@index');
Route::post('/mutual/registrar', 'MutualController@store');
Route::put('/mutual/actualizar', 'MutualController@update');
Route::put('/mutual/desactivar', 'MutualController@desactivar');
Route::put('/mutual/activar', 'MutualController@activar');
Route::get('/mutual/selectMutual', 'MutualController@selectMutual');

Route::get('/representante', 'representanteController@index');
Route::post('/representante/registrar', 'representanteController@store');
Route::put('/representante/actualizar', 'representanteController@update');
Route::put('/representante/desactivar', 'representanteController@desactivar');
Route::put('/representante/activar', 'representanteController@activar');
Route::get('/representante/selectRepresentante', 'representanteController@selectRepresentante');

Route::get('/empresa', 'empresaController@index');
Route::post('/empresa/registrar', 'empresaController@store');
Route::put('/empresa/actualizar', 'empresaController@update');
Route::put('/empresa/desactivar', 'empresaController@desactivar');
Route::put('/empresa/activar', 'empresaController@activar');

Route::get('/afp', 'afpController@index');
Route::post('/afp/registrar', 'afpController@store');
Route::put('/afp/actualizar', 'afpController@update');
Route::put('/afp/desactivar', 'afpController@desactivar');
Route::put('/afp/activar', 'afpController@activar');

Route::get('/salud', 'saludController@index');
Route::post('/salud/registrar', 'saludController@store');
Route::put('/salud/actualizar', 'saludController@update');
Route::put('/salud/desactivar', 'saludController@desactivar');
Route::put('/salud/activar', 'saludController@activar');