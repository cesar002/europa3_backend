<?php

namespace App\Http\Controllers;

use App\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MunicipiosController extends Controller{
	public function index(){
		$municipios = Municipio::all();

		return response($municipios);
	}

	public function show($id){
		try {
			$municipio = Municipio::findOrFail($id);

			return response($municipio);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response(json_encode([], JSON_FORCE_OBJECT));
		}
	}

	public function getByEstadoId($id){
		try {
			$municipio = Municipio::where('estado_id', $id)->orderBy('nombre')->get();

			return response($municipio);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response(json_encode([], JSON_FORCE_OBJECT));
		}
	}

}
