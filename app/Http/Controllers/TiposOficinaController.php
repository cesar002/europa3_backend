<?php

namespace App\Http\Controllers;

use App\CatTipoOficina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TiposOficinaController extends Controller{

	public function index(){
		$tipos = CatTipoOficina::all();

		return response($tipos);
	}

	public function store(\App\Http\Requests\TiposOficinaRequest $request){
		try {
			$tipo = new CatTipoOficina();
			$tipo->tipo = $request->nombre;
			$tipo->save();

			return response([
				'message' => 'Tipo de oficina registrada con éxito'
			], 201);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al registrar el tipo de oficina'
			], 500);
		}
	}

	public function update(\App\Http\Requests\TiposOficinaRequest $request, $id){
		try {
			$tipo = CatTipoOficina::find($id);
			$tipo->tipo = $request->nombre;
			$tipo->save();

			return response([
				'message' => 'Tipo de oficina actualizada con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al actualizar el tipo de oficina'
			], 500);
		}
	}

}
