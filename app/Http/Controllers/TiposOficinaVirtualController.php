<?php

namespace App\Http\Controllers;

use App\CatTipoOficinaVirtual;
use Illuminate\Support\Facades\Log;

class TiposOficinaVirtualController extends Controller{

	public function index(){
		$tipoVirtual = CatTipoOficinaVirtual::all();

		return response($tipoVirtual);
	}

	public function store(\App\Http\Requests\TiposOficinaVirtualRequest $request){
		try {

			$tipoVirtual = new CatTipoOficinaVirtual();
			$tipoVirtual->tipo = $request->nombre;
			$tipoVirtual->save();

			return response([
				'message' => 'Tipo de oficina virtual registrada con éxito'
			], 201);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al registrar el tipo de oficina virtua'
			], 500);
		}
	}

	public function update(\App\Http\Requests\TiposOficinaVirtualRequest $request, $id){
		try {
			$tipoVirtual = CatTipoOficinaVirtual::findOrFail($id);
			$tipoVirtual->tipo = $request->nombre;
			$tipoVirtual->save();

			return response([
				'message' => 'Tipo de oficina virtual actualizada con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al actualizar el tipo de oficina virtua'
			], 500);
		}
	}

}
