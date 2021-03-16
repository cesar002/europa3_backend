<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
	Route::get('/login', 'Dashboard\AuthAdminController@index')->name('login-view');
	Route::post('/login', 'Dashboard\AuthAdminController@login')->name('login');

	Route::middleware(['auth-admin'])->group(function () {
		Route::get('/inicio', 'Dashboard\InicioController@index')->name('inicio');

		Route::group(['prefix' => 'edificios', 'as' => 'edificios.'], function(){
			Route::get('/', 'Dashboard\EdificiosController@index')->name('index');
			Route::get('/{id}', 'Dashboard\EdificiosController@show')->name('show');
		});

		Route::group(['prefix' => 'oficinas', 'as' => 'oficinas.'], function(){
			Route::get('/', 'Dashboard\OficinasController@index')->name('index');
			Route::get('/{id}', 'Dashboard\OficinasController@show')->name('show');
			Route::get('/{id}/imagenes', 'Dashboard\OficinasController@showImagenesUpdate')->name('updateImage');
		});

		Route::group(['prefix' => 'oficinas-virtuales', 'as' => 'oficinas-virtuales.'], function(){
			Route::get('/', 'Dashboard\OficinasVirtualesController@index')->name('index');
			Route::post('/', 'Dashboard\OficinasVirtualesController@store')->name('store');
		});

		Route::group(['prefix' => 'sala-juntas', 'as' => 'sala-juntas.'], function(){
			Route::get('/', 'Dashboard\SalaJuntasController@index')->name('index');
			Route::get('/{id}', 'Dashboard\SalaJuntasController@show')->name('show');
		});

		Route::group(['prefix' => 'mobiliario', 'as' => 'mobiliario.'], function(){
			Route::get('/', 'Dashboard\MobiliarioController@index')->name('index');
			Route::get('/{id}', 'Dashboard\MobiliarioController@show')->name('show');
			Route::get('/{id}/distribucion', 'Dashboard\MobiliarioController@showDistribucion')->name('distribucion');
			Route::post('/', 'Dashboard\MobiliarioController@store')->name('store');
			Route::post('/{id}', 'Dashboard\MobiliarioController@update')->name('update');
		});

		Route::group(['prefix' => 'servicios', 'as' => 'servicios.'], function(){
			Route::get('/', 'Dashboard\ServiciosController@index')->name('index');
		});

		Route::group(['prefix' => 'adicionales', 'as' => 'adicionales.'], function(){
			Route::get('/', 'Dashboard\AdicionalesController@index')->name('index');
			Route::post('/', 'Dashboard\AdicionalesController@store')->name('store');
		});

		Route::group(['prefix' => 'idiomas-atencion', 'as' => 'idiomas-atencion.'], function(){
			Route::get('/', 'Dashboard\IdiomasAtencionController@index')->name('index');
		});
	});

});
