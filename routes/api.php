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

	Route::group(['prefix' => 'auth'], function () {
		Route::post('user', 'AuthUserController@login');
		Route::post('admin', 'AuthUserAdminController@login');

		Route::group(['prefix' => 'me', 'middleware' => 'auth:api'], function () {
			Route::get('/', 'UserController@getCurrentAuthUser');
		});
	});

	//** EDIFICIOS */
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
