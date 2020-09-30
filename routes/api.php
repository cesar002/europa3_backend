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

		Route::group(['prefix' => 'admin/me'], function () {
			Route::get('/', 'UserAdminController@getDataCurrenUser');
		});

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

	//** TIPO DE PAGO */

	Route::get('/metodos-pago', 'MetodoPagoController@index');
	Route::get('/metodo-pago/{id}', 'MetodoPagoController@show');
	Route::post('/metodo-pago', 'MetodoPagoController@store');
	Route::put('/metodo-pago/{id}', 'MetodoPagoController@update');

	Route::get('/referencia-pago/{id}', 'ReferenciaPagoController@show');
	Route::post('/referencia-pago', 'ReferenciaPagoController@store');
	Route::put('/referencia-pago/{id}', 'ReferenciaPagoController@update');
	Route::delete('/referencia-pago/{id}', 'ReferenciaPagoController@destroy');

	//****************/

	//** SOLICITUDES */

	Route::get('/solicitudes-renta', 'SolicitudesRentaController@index');
	Route::get('/solicitud-renta/{id}', 'SolicitudesRentaController@show');
	Route::post('/solicitud-renta', 'SolicitudesRentaController@store');

	// Route::get('/wea', function () {

	// 	// echo $currentDate->addMonthsNoOverflow(1)->toDateString();
	// 	for ($i=1; $i <= 6; $i++) {
	// 		$currentDate = Carbon::createFromDate(2020, 10, 31, 'Europe/Madrid');
	// 		echo "<p>".$currentDate->addMonthsNoOverflow($i)->toDateString()."</p>";
	// 	}
	// });

	//****************/

	//** MOBILIARIO */

	Route::get('/tipo-mobiliario',  'TiposMobiliarioController@index');
	Route::post('/tipo-mobiliario', 'TiposMobiliarioController@store');
	Route::put('/tipo-mobiliario/{id}',  'TiposMobiliarioController@update');

	Route::post('/mobiliario-oficina', 'MobiliarioOficinaController@store');
	Route::delete('/mobiliario-oficina/oficina/{idOficina}/mobiliario/{idMobiliario}', 'MobiliarioOficinaController@destroy');

	Route::get('/mobiliario', 'MobiliarioController@index');
	Route::get('/mobiliario/edificio/{id}', 'MobiliarioController@getByEdificio');
	Route::get('/mobiliario/{id}', 'MobiliarioController@show');

	Route::post('/mobiliario', 'MobiliarioController@store');
	Route::put('/mobiliario/{id}', 'MobiliarioController@update');
	Route::delete('/mobiliario/{id}', 'MobiliarioController@destroy');

	//*****************/

	//** OFICINA Y CATALOGOS */

	Route::get('/demo', function () {
		echo phpinfo();
	});

	Route::get('/oficina-size', 'OficinaSizeController@index');
	Route::post('/oficina-size', 'OficinaSizeController@store');
	Route::put('/oficina-size/{id}', 'OficinaSizeController@update');

	Route::post('/oficina-images/{id}', 'OficinaImageController@update');

	Route::get('/tipos-oficina', 'TiposOficinaController@index');
	Route::post('/tipos-oficina', 'TiposOficinaController@store');
	Route::put('/tipos-oficina/{id}', 'TiposOficinaController@update');

	Route::get('/tipos-oficina-virtual', 'TiposOficinaVirtualController@index');
	Route::post('/tipos-oficina-virtual', 'TiposOficinaVirtualController@store');
	Route::put('/tipos-oficina-virtual/{id}', 'TiposOficinaVirtualController@update');

	Route::get('/servicios', 'ServiciosController@index');
	Route::post('/servicio', 'ServiciosController@store');
	Route::patch('/servicio/{id}', 'ServiciosController@update');

	Route::get('/oficinas', 'OficinasController@getOficinas');
	Route::get('/oficina/{id}', 'OficinasController@show');
	Route::get('/oficina/{id}/images', 'OficinaImageController@show');
	Route::get('/oficinas/municipio/{id}', 'OficinasController@getOficinasByMunicipio');
	Route::get('/oficinas/estado/{id}', 'OficinasController@getOficinasByEstado');
	Route::get('/oficinas/edificio/{id}', 'OficinasController@getOficinasByEdificioId');

	Route::post('/oficina', 'OficinasController@store');
	Route::put('/oficina/{id}', 'OficinasController@update');
	Route::delete('/oficina/{id}', 'OficinasController@destroy');

	//*************************/

	//** EDIFICIOS Y CATALOGOS */
	Route::get('/idiomas-atencion', 'IdiomasAtencionController@index');
	Route::post('/idioma-atencion', 'IdiomasAtencionController@store');
	Route::put('/idioma-atencion/{id}', 'IdiomasAtencionController@update');

	Route::post('/edificio', 'EdificioController@store');
	Route::put('/edificio/{id}', 'EdificioController@update');
	Route::delete('/edificio/{id}', 'EdificioController@destroy');

	Route::get('/edificios', 'EdificioController@index');
	Route::get('/edificio/{id}', 'EdificioController@show');
	Route::get('/edificios/municipio/{municipioId}', 'EdificioController@getByMunicipioId');
	Route::get('/edificios/estado/{estadoId}', 'EdificioController@getByEstadoId');
	Route::get('/edificios/estado/{estadoId}/municipio/{municipioId}', 'EdificioController@getByEstadoIdAndMunicipioId');
	//**************/

	//** ESTADOS Y MUNICIPIOS */
	Route::get('/estados', 'EstadosController@index');
	Route::get('/estado/{id}', 'EstadosController@show');
	Route::get('/municipios', 'MunicipiosController@index');
	Route::get('/municipio/{id}', 'MunicipiosController@show');
	Route::get('/municipios/estado/{id}', 'MunicipiosController@getByEstadoId');
	//************************/

});
