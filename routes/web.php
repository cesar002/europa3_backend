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

	Route::get('/inicio', 'Dashboard\InicioController@index')->name('inicio');

});
