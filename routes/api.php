<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'v1'], function () {

	Route::group(['prefix' => 'register'], function () {
		Route::post('user', 'AuthUserController@register');
		Route::post('admin', 'AuthUserAdminController@register');
	});

	//** USUARIO AUTENTICADO */
	Route::group(['prefix' => 'auth'], function () {
		Route::post('user', 'AuthUserController@login');
		Route::post('admin', 'AuthUserAdminController@login');

		Route::group(['prefix' => 'me', 'middleware' => 'auth:api'], function () {
			Route::get('/', 'UserController@getCurrentAuthUser');

			Route::group(['prefix' => 'datos-personales'], function () {
				Route::post('/', 'DatosPersonalesController@store');
				Route::put('/', 'DatosPersonalesController@update');
			});

			Route::group(['prefix' => 'datos-morales'], function () {
				Route::post('/', 'DatosMoralesController@store');
				Route::put('/', 'DatosMoralesController@update');
			});

			Route::group(['prefix' => 'datos-fiscales'], function () {
				Route::post('/', 'DatosFiscalesController@store');
				Route::put('/', 'DatosFiscalesController@update');
			});
		});
	});
	//********************/

	//** USUARIOS */

	//**************/

	//** CONFIG DE DATOS */
	Route::group(['prefix' => 'config'], function () {
		Route::put('/renovacion', 'ConfigDataController@updateRenovacionConfig');
		Route::put('/renta', 'ConfigDataController@updateRentaConfig');
	});
	//*******************/

	//** OFICINA Y CATALOGOS */

	Route::get('/oficina-size', 'OficinaSizeController@index');
	Route::post('/oficina-size', 'OficinaSizeController@store');
	Route::put('/oficina-size/{id}', 'OficinaSizeController@update');

	Route::get('/tipos-oficina', 'TiposOficinaController@index');
	Route::post('/tipos-oficina', 'TiposOficinaController@store');
	Route::put('/tipos-oficina/{id}', 'TiposOficinaController@update');

	Route::get('/tipos-oficina-virtual', 'TiposOficinaVirtualController@index');
	Route::post('/tipos-oficina-virtual', 'TiposOficinaVirtualController@store');
	Route::put('/tipos-oficina-virtual/{id}', 'TiposOficinaVirtualController@update');

	Route::get('/servicios', 'OficinaSizeController@index');
	Route::post('/servicios', 'OficinaSizeController@store');
	Route::put('/servicios/{id}', 'OficinaSizeController@update');

	Route::get('/oficinas', 'OficinasController@getOficinas');
	Route::get('/oficina/{id}', 'OficinasController@show');
	Route::get('/oficinas/municipio/{id}', 'OficinasController@getOficinasByMunicipio');
	Route::get('/oficinas/estado/{id}', 'OficinasController@getOficinasByEstado');

	Route::post('/oficina', 'OficinasController@store');
	Route::put('/oficina/{id}', 'OficinasController@update');
	Route::delete('/oficina/{id}', 'OficinasController@destroy');

	//*************************/

	//** EDIFICIOS Y CATALOGOS */
	Route::get('/idiomas-atencion', 'IdiomasAtencionController@index');
	Route::post('/idiomas-atencion', 'IdiomasAtencionController@store');
	Route::put('/idiomas-atencion/{id}', 'IdiomasAtencionController@update');

	Route::post('/edificio', 'EdificioController@store');
	Route::put('/edificio/{id}', 'EdificioController@update');
	Route::delete('/edificio/{id}', 'EdificioController@destroy');

	Route::get('/edificios', 'EdificioController@index');
	Route::get('/edificio/{id}', 'EdificioController@show');
	Route::get('/edificios/municipio/{municipioId}', 'EdificioController@getByMunicipioId');
	Route::get('/edificios/estado/{estadoId}', 'EdificioController@getByEstadoId');
	Route::get('/edificios/estado/{estadoId}/municipio/{municipioId}', 'EdificioController@getByEstadoIdAndMunicipioId');
	//**************/

});
