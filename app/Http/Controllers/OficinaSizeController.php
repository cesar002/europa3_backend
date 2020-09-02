<?php

namespace App\Http\Controllers;

use App\CatSizeOficina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OficinaSizeController extends Controller
{

	public function index(){
		$sizes = CatSizeOficina::all();

		return response($sizes);
	}

	public function store(\App\Http\Requests\OficinaSizeStoreRequest $request){
		try {
			$size = new CatSizeOficina([
				'size' => $request->nombre,
				'precio' => $request->precio
			]);

			$size->save();

			return response([
				'message' => 'El tamaño de oficina se registró con éxito'
			], 201);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al registrar el tamaño'
			], 500);
		}
	}

	public function update(\App\Http\Requests\OficinaSizeUpdateRequest $request, $id){
		try {
			$size = CatSizeOficina::findOrFail($id);

			$size->size = $request->nombre;
			$size->precio = $request->precio;

			$size->save();

			return response([
				'message' => 'Se actualizó con éxito el tamaño de oficina'
			], 201);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al actualizar el tamaño'
			], 500);
		}
	}

}
