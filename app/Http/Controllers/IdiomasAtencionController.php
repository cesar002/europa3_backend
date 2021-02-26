<?php

namespace App\Http\Controllers;

use App\CatIdiomasAtencion;
use Illuminate\Support\Facades\Log;

class IdiomasAtencionController extends Controller{

	public function index(){
		$idiomas = CatIdiomasAtencion::all();

		return response($idiomas);
	}

	public function store(\App\Http\Requests\IdiomasAtencionRequest $request){
		try {
			$idioma = new CatIdiomasAtencion();
			$idioma->idioma = $request->nombre;
			$idioma->save();

			return response([
				'message' => 'Idioma de atención creado con éxito'
			], 201);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'message' => 'Ocurrió un error al registrar el idioma de atención'
			], 500);
		}
	}

	public function update(\App\Http\Requests\IdiomasAtencionRequest $request, $id){
		try {

			$idioma = CatIdiomasAtencion::findOrFail($id);
			$idioma->idioma = $request->nombre;
			$idioma->save();

			return response([
				'message' => 'Idioma de atención actualizado con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'message' => 'Ocurrió un error al actualizar el idoma de atención'
			], 500);
		}
	}

}
