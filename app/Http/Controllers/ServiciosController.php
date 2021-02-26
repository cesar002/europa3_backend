<?php

namespace App\Http\Controllers;

use App\CatServiciosOficina;
use Illuminate\Support\Facades\Log;

class ServiciosController extends Controller{

	public function index(){

		$servicios = CatServiciosOficina::all();

		return response($servicios);
	}

	public function store(\App\Http\Requests\ServiciosRequest $request){
		try {
			$servicio = new CatServiciosOficina();

			$servicio->servicio = $request->nombre;

			$servicio->save();

			return response([
				'message' => 'Servicio registrado con éxito'
			], 201);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al registrar el servicio'
			], 500);
		}
	}

	public function update(\App\Http\Requests\ServiciosRequest $request, $id){
		try {
			$servicio = CatServiciosOficina::findOrFail($id);

			$servicio->servicio = $request->nombre;

			$servicio->save();

			return response([
				'message' => 'Servicio actualizado con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al actualizar el servicio'
			]);
		}
	}

}
