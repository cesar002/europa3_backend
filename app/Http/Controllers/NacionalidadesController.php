<?php

namespace App\Http\Controllers;

use App\Nacionalidad;

class NacionalidadesController extends Controller
{
    public function index(){
		try {
			$data = Nacionalidad::all();

			return response($data);
		} catch (\Throwable $th) {
			return response([
				'error' => 'No se pudo obtener la información de las nacionalidades'
			], 500);
		}
	}
}
