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
Route::get('/empresa/selectEmpresa', 'EmpresaController@selectEmpresa');

Route::get('/afp', 'afpController@index');
Route::post('/afp/registrar', 'afpController@store');
Route::put('/afp/actualizar', 'afpController@update');
Route::put('/afp/desactivar', 'afpController@desactivar');
Route::put('/afp/activar', 'afpController@activar');
Route::get('/afp/selectAfp', 'AfpController@selectAfp');

Route::get('/salud', 'saludController@index');
Route::post('/salud/registrar', 'saludController@store');
Route::put('/salud/actualizar', 'saludController@update');
Route::put('/salud/desactivar', 'saludController@desactivar');
Route::put('/salud/activar', 'saludController@activar');
Route::get('/salud/selectSalud', 'SaludController@selectSalud');

Route::get('/empleado', 'empleadoController@index');
Route::post('/empleado/registrar', 'empleadoController@store');
Route::put('/empleado/actualizar', 'empleadoController@update');
Route::put('/empleado/desactivar', 'empleadoController@desactivar');
Route::put('/empleado/activar', 'empleadoController@activar');
Route::get('/empleado/selectEmpleado', 'EmpleadoController@selectEmpleado');

Route::get('/sucursal', 'sucursalController@index');
Route::post('/sucursal/registrar', 'sucursalController@store');
Route::put('/sucursal/actualizar', 'sucursalController@update');
Route::put('/sucursal/desactivar', 'sucursalController@desactivar');
Route::put('/sucursal/activar', 'sucursalController@activar');
Route::get('/sucursal/selectSucursal', 'SucursalController@selectSucursal');

Route::get('/finiquito', 'finiquitoController@index');
Route::post('/finiquito/registrar', 'finiquitoController@store');
Route::put('/finiquito/actualizar', 'finiquitoController@update');
Route::put('/finiquito/desactivar', 'finiquitoController@desactivar');
Route::put('/finiquito/activar', 'finiquitoController@activar');

Route::get('/licencia', 'licenciaController@index');
Route::post('/licencia/registrar', 'licenciaController@store');
Route::put('/licencia/actualizar', 'licenciaController@update');
Route::put('/licencia/desactivar', 'licenciaController@desactivar');
Route::put('/licencia/activar', 'licenciaController@activar');

Route::get('/carga', 'cargaController@index');
Route::post('/carga/registrar', 'cargaController@store');
Route::put('/carga/actualizar', 'cargaController@update');
Route::put('/carga/desactivar', 'cargaController@desactivar');
Route::put('/carga/activar', 'cargaController@activar');

Route::get('/contrato', 'contratoController@index');
Route::post('/contrato/registrar', 'contratoController@store');
Route::put('/contrato/actualizar', 'contratoController@update');
Route::put('/contrato/desactivar', 'contratoController@desactivar');
Route::put('/contrato/activar', 'contratoController@activar');

Route::get('/haber', 'haberController@index');
Route::post('/haber/registrar', 'haberController@store');
Route::put('/haber/actualizar', 'haberController@update');
Route::put('/haber/desactivar', 'haberController@desactivar');
Route::put('/haber/activar', 'haberController@activar');
Route::get('/haber/selectHaber', 'HaberController@selectHaber');

Route::get('/descuento', 'descuentoController@index');
Route::post('/descuento/registrar', 'descuentoController@store');
Route::put('/descuento/actualizar', 'descuentoController@update');
Route::put('/descuento/desactivar', 'descuentoController@desactivar');
Route::put('/descuento/activar', 'descuentoController@activar');
Route::get('/descuento/selectDescuento', 'DescuentoController@selectDescuento');

Route::get('/liquidacion', 'liquidacionController@index');
Route::post('/liquidacion/registrar', 'liquidacionController@store');
Route::put('/liquidacion/actualizar', 'liquidacionController@update');
Route::put('/liquidacion/desactivar', 'liquidacionController@desactivar');
Route::put('/liquidacion/activar', 'liquidacionController@activar');
Route::get('/liquidacion/selectLiquidacion', 'LiquidacionController@selectLiquidacion');

Route::get('/tablaDeValores', 'tablaDeValoresController@index');
Route::post('/tablaDeValores/registrar', 'tablaDeValoresController@store');
Route::put('/tablaDeValores/actualizar', 'tablaDeValoresController@update');
Route::put('/tablaDeValores/desactivar', 'tablaDeValoresController@desactivar');
Route::put('/tablaDeValores/activar', 'tablaDeValoresController@activar');
Route::get('/tablaDeValores/selectTablaDeValores', 'TablaDeValoresController@selectTablaDeValores');