<?php

namespace App\Http\Controllers;

use App\CatReferenciaPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReferenciaPagoController extends Controller
{

	public function show($id){
		try {
			$referencia = CatReferenciaPago::findOrFail($id);

			return response($referencia);
		} catch (\Throwable $th) {
			return response([]);
		}
	}

	public function store(\App\Http\Requests\ReferenciaPagoRequest $request){
		try {

			$referencia = new CatReferenciaPago([
				'tipo_pago_id' => $request->tipo_pago_id,
				'referencia' => $request->referencia,
				'entidad_bancaria' => $request->entidad_bancaria,
			]);

			$referencia->save();

			return response([
				'message' => 'Referencia de pago registrada con éxito'
			], 201);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al registrar la referencia de pago'
			], 500);
		}
	}

	public function update(\App\Http\Requests\ReferenciaPagoRequest $request, $id){
		try {

			$referencia = CatReferenciaPago::findOrFail($id);

			$referencia->tipo_pago_id = $request->tipo_pago_id;
			$referencia->referencia = $request->referencia;
			$referencia->entidad_bancaria = $request->entidad_bancaria;

			$referencia->save();

			return response([
				'message' => 'Referencia de pago actualizada con éxito'
			], 201);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al actualizar la referencia de pago'
			], 500);
		}
	}

	public function destroy($id){
		try {

			$referencia = CatReferenciaPago::findOrFail($id);

			$referencia->delete();

			return response([
				'message' => 'Referencia de pago eliminada con éxito'
			], 201);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al eliminar la referencia de pago'
			], 500);
		}
	}

}
