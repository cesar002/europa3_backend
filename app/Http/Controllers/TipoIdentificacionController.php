<?php

namespace App\Http\Controllers;

use App\TipoIdentificacion;

class TipoIdentificacionController extends Controller
{
    public function index(){
		try {
			$tipos = TipoIdentificacion::all();

			return response($tipos);
		} catch (\Throwable $th) {
			return response([
				'error' => 'No se pudieron obtener los datos'
			], 500);
		}
	}
}
