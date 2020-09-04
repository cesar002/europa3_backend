<?php

namespace App\Http\Controllers;

use App\TipoMobiliario;
use Illuminate\Support\Facades\Log;

class TiposMobiliarioController extends Controller{

	public function index(){
		$tipos = TipoMobiliario::all();

		return response($tipos);
	}

	public function store(\App\Http\Requests\TiposMobiliarioRequest $request){
		try {

			$tipo = new TipoMobiliario();

			$tipo->tipo = $request->nombre;

			$tipo->save();

			return response([
				'message' => 'Tipo de mobiliario registrado con éxito'
			], 201);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([

			], 500);
		}
	}

	public function update(\App\Http\Requests\TiposMobiliarioRequest $request, $id){
		try {
			$tipo = TipoMobiliario::findOrFail($id);
			$tipo->tipo = $request->nombre;

			$tipo->save();

			return response([
				'message' => 'Tipo de mobiliario actualizado con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([

			], 500);
		}
	}

	public function destroy(){
		try {

		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([

			], 500);
		}
	}

}
