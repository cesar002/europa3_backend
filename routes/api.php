<?php

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

Route::get('/test', 'TestController@index');

Route::group(['prefix' => 'v1'], function () {

	Route::group(['prefix' => 'register'], function () {
		Route::post('user', 'AuthUserController@register');
		Route::post('admin', 'AuthUserAdminController@register')->middleware('auth:api-admin');
	});

	Route::group(['prefix' => 'gestion-usuarios', 'middleware' => 'auth:api-admin'], function(){
		Route::get('/', 'GestionUsuariosSystemController@index');
	});

	//** USUARIO AUTENTICADO */
	Route::group(['prefix' => 'auth'], function () {
		Route::post('user', 'AuthUserController@login');
		Route::post('admin', 'AuthUserAdminController@login');

		Route::post('user/logout', 'AuthUserController@logout')->middleware('auth:api');
		Route::post('admin/logout', 'AuthUserAdminController@logout')->middleware('auth:api-admin');

		Route::group(['prefix' => 'admin/me', 'middleware' => 'auth:api-admin'], function () {
			Route::get('/', 'UserAdminController@getDataCurrenUser');

			Route::group(['prefix' => 'notifications'], function () {
				Route::get('/', 'NotificationsAdminController@getNotifications');
				Route::delete('/', 'NotificationsAdminController@destroyAll');
				Route::delete('/{id}', 'NotificationsAdminController@destroy');
			});
		});

		Route::group(['prefix' => 'me', 'middleware' => 'auth:api'], function () {
			Route::get('/', 'UserController@getCurrentAuthUser');

			Route::post('/push-token', 'PushTokensController@register');

			Route::group(['prefix' => 'datos-personales'], function () {
				Route::post('/', 'DatosPersonalesController@store');
				Route::put('/', 'DatosPersonalesController@update');
			});

			Route::group(['prefix' => 'datos-morales'], function () {
				Route::get('/', 'DatosMoralesController@getFromCurrentUser');
				Route::post('/', 'DatosMoralesController@store');
				Route::put('/', 'DatosMoralesController@update');
			});

			Route::group(['prefix' => 'datos-fiscales'], function () {
				Route::get('/', 'DatosFiscalesController@getFromCurrentUser');
				Route::post('/', 'DatosFiscalesController@store');
				Route::put('/', 'DatosFiscalesController@update');
			});
		});
	});
	//********************/

	Route::get('/users', 'UserController@getAllUsuarios')->middleware('auth:api-admin');

	//** SOLICITUDES*/
	Route::group(['middleware' => ['auth:api-admin']], function () {
		Route::get('solicitudes', 'SolicitudController@index');
		Route::patch('solicitud/document/{id}/validate', 'DocumentosSolicitudController@validateDocument');
		Route::patch('solicitud/document/{id}/invalidate', 'DocumentosSolicitudController@invalidateDocument');
		Route::get('solicitud/document/{id}/download', 'DocumentosSolicitudController@downloadDocument');
		Route::patch('solicitud/document/{id}/allow-update', 'DocumentosSolicitudController@allowUpdateDocument');
		Route::post('solicitud/{id}/authorize', 'SolicitudController@autorizar');
		Route::post('solicitud/{id}/no-authorize', 'SolicitudController@noAutorizar');
		Route::put('solicitud/{id}/finalize', 'SolicitudController@finalizar');
	});

	Route::group(['middleware' => ['auth:api']], function () {
		Route::get('solicitudes/me', 'SolicitudController@getToUser');
		Route::get('solicitudes/historial', 'SolicitudController@getUserHistory');
		Route::get('solicitud/{id}/documents', 'SolicitudController@getDocuments');
		Route::post('solicitud/{id}/cancel', 'SolicitudController@cancelar');
		Route::post('solicitud', 'SolicitudController@storeSolicitudOficina');
		Route::post('solicitud/{id}/upload-document', 'DocumentosSolicitudController@uploadDocument');
		Route::post('solicitud/document/update', 'DocumentosSolicitudController@updateDocumento');
		Route::post('solicitud/{id}/confirmar', 'PagosController@payConfirmationSolicitud');
		Route::post('solicitud/{id}/fecha/{idFecha}/pagar', 'PagosController@payMesSolicitud');
		Route::get('solicitud/{id}/adicionales', 'SolicitudController@getAdicionalesSolicitud');
		Route::post('solicitud/{id}/adicionales/pagar', 'PagosController@payAdicionales');
	});

	Route::get('solicitud/{id}', 'SolicitudController@show')->middleware('auth:api,api-admin');
	Route::get('solicitud/{id}/admin', 'SolicitudController@showAdmin')->middleware('auth:api,api-admin');
	//**********************

	//** ADICIONALES */
	Route::get('cat-unidades', 'CatUnidadesController@index');
	Route::get('adicionales', 'AdicionalesController@index');
	Route::get('adicionales/edificio/{id}', 'AdicionalesController@getByEdificioId');
	Route::get('adicional/{id}', 'AdicionalesController@show');
	Route::post('adicional', 'AdicionalesController@store')->middleware('auth:api-admin');
	Route::put('adicional/{id}', 'AdicionalesController@update')->middleware('auth:api-admin');
	Route::delete('adicional/{id}', 'AdicionalesController@destroy')->middleware('auth:api-admin');
	Route::put('adicionales-comprados/usar', 'AdicionalesCompraController@updateUsado');
	Route::post('adicionales/comprar', 'AdicionalesCompraController@store');
	//******************/

	//** ADICIONALES COMPRA */

	//********************/

	//** CHAT SOLICITUD */
	Route::get('chat/chats/solicitudes/user', 'ChatRecepcionController@getSolicitudesByUserId')->middleware('auth:api');
	Route::get('chat/chats/solicitudes', 'ChatRecepcionController@getSolicitudesChat')->middleware('auth:api-admin');
	Route::post('chat/recepcion', 'ChatRecepcionController@receiveUserMessageChat')->middleware('auth:api');
	Route::post('chat/recepcion/edificio', 'ChatRecepcionController@receiveEdificioMessageChat')->middleware('auth:api-admin');
	Route::get('chat/recepcion/solicitud/{id}', 'ChatRecepcionController@getChatMessageSolicitud')->middleware('auth:api,api-admin');
	//***********************/

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

	//** TIPO DE TIEMPOS DE RENTA  */
	Route::get('/tiempos-renta', 'TipoTiempoController@index');
	//*****************/

	//** MOBILIARIO */

	Route::get('/tipo-mobiliario',  'TiposMobiliarioController@index');
	Route::post('/tipo-mobiliario', 'TiposMobiliarioController@store');
	Route::put('/tipo-mobiliario/{id}',  'TiposMobiliarioController@update');

	Route::post('/mobiliario-oficina', 'MobiliarioOficinaController@store');
	Route::delete('/mobiliario-oficina/oficina/{idOficina}/mobiliario/{idMobiliario}', 'MobiliarioOficinaController@destroy');

	Route::get('/mobiliario', 'MobiliarioController@index');
	Route::get('/mobiliario/edificio/{id}', 'MobiliarioController@getByEdificio');
	Route::get('/mobiliario/{id}', 'MobiliarioController@show');

	Route::post('/mobiliario', 'MobiliarioController@store')->middleware('auth:api-admin');
	Route::post('/mobiliario/{id}', 'MobiliarioController@update')->middleware('auth:api-admin');
	Route::delete('/mobiliario/{id}', 'MobiliarioController@destroy')->middleware('auth:api-admin');

	//*****************/

	//** SALA DE JUNTAS */
	Route::get('/salas-juntas', 'SalaJuntaController@index');
	Route::get('/sala-juntas/{id}', 'SalaJuntaController@show');
	Route::get('/sala-juntas/{id}/images', 'SalaJuntasImagesController@show');

	Route::post('/sala-juntas', 'SalaJuntaController@store');
	Route::post('/sala-juntas-images/{id}', 'SalaJuntasImagesController@update');

	Route::put('/sala-juntas/{id}', 'SalaJuntaController@update');
	//*******************/

	//** OFICINA Y CATALOGOS */
	Route::get('/lista-documentos', 'DocumentosSolicitudController@getListDocuments');

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

	Route::get('/oficinas-virtuales', 'OficinaVirtualController@index');
	Route::get('/oficina-virtual/{id}', 'OficinaVirtualController@show');
	Route::post('/oficina-virtual', 'OficinaVirtualController@store')->middleware('auth:api-admin');
	Route::put('/oficina-virtual/{id}', 'OficinaVirtualController@update')->middleware('auth:api-admin');
	Route::delete('/oficina-virtual/{id}', 'OficinaVirtualController@destroy')->middleware('auth:api-admin');

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

	//** CATALOGOS GENERALES */
	Route::group(['prefix' => 'cat'], function () {
		Route::get('/tipos-identificacion', 'TipoIdentificacionController@index');
		Route::get('/nacionalidades', 'NacionalidadesController@index');
	});


	//** AGENDA USUARIO */
	Route::group(['prefix' => 'agenda', ['middleware' => 'auth:api']], function(){
		Route::get('/', 'AgendaController@index');
		Route::get('/{id}', 'AgendaController@show');
		Route::post('/', 'AgendaController@store');
		Route::put('/{id}', 'AgendaController@update');
		Route::delete('/{id}', 'AgendaController@destroy');
	});

	Route::post('/solicitud-visita', 'SolicitudVisitaController@store');
	Route::get('/solicitudes-visita', 'SolicitudVisitaController@index')->middleware('auth:api-admin');
	Route::delete('/solicitud-visita/{id}', 'SolicitudVisitaController@destroy')->middleware('auth:api-admin');
	Route::patch('/solicitud-visita/{id}', 'SolicitudVisitaController@update')->middleware('auth:api-admin');

});
