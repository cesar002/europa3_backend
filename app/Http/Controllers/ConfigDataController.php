<?php

namespace App\Http\Controllers;

use App\RenovacionConfig;
use App\RentaConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConfigDataController extends Controller
{

	public function updateRenovacionConfig(\App\Http\Requests\RenovacionConfigRequest $request){
		try {
			$minimo = RenovacionConfig::find(1);

			$minimo->meses_notificacion = $request->meses_notificacion;
			$minimo->minimo_renovacion = $request->minimo_renovacion;
			$minimo->save();

			return response([
				'message' => 'Información actualizada con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'No se pudo actualizar'
			], 500);
		}
	}

	public function updateRentaConfig(\App\Http\Requests\RentaConfigRequest $request){
		try {
			$renta = RentaConfig::find(1);

			$renta->minimo_renta = $request->minimo_renta;
			$renta->maximo_renta = $request->maximo_renta;
			$renta->save();

			return response([
				'message' => 'Información actualizada con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'No se pudo actualizar'
			], 500);
		}
	}

}
