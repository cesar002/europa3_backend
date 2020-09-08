<?php

namespace App\Http\Controllers;

use App\MobiliarioOficina;
use App\Oficina;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

;

class MobiliarioOficinaController extends Controller{


	public function store(\App\Http\Requests\MobiliarioOficinaRequest $request){
		try {

			$mobiliarioId = $request->mobiliario_id;
			$oficina = Oficina::with('edificio', 'edificio', 'edificio.mobiliario')->findOrFail($request->oficina_id);

			$mobiliario = $oficina->edificio->mobiliario->first(function($m, $key) use ($mobiliarioId) {
				return $m->id == $mobiliarioId;
			});

			$total = DB::select('SELECT COUNT(*) AS total FROM mobiliario_oficina_table WHERE oficina_id = ?', [$request->oficina_id]);

			if($total[0]->total >= $mobiliario->cantidad ){
				return response([
					'message' => 'No se puede agregar mas mobiliario a la oficina'
				], 409);
			}

			$mobiliario = new MobiliarioOficina();

			$mobiliario->oficina_id = $request->oficina_id;
			$mobiliario->mobiliario_id = $request->mobiliario_id;

			$mobiliario->save();

			return response([
				'message' => 'Se asigno el mobiliario a la oficina con éxito'
			],201);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al registrar el mobiliario a la oficina'
			], 201);
		}
	}


	public function destroy(\App\Http\Requests\MobiliarioOficinaRequest $request, $idOficina, $idMobiliario){
		try {
			$mobiliario = MobiliarioOficina::whereRaw(' oficina_id = ? and mobiliario_id = ? ', [ $idOficina, $idMobiliario ])->firstOrFail();

			$mobiliario->delete();

			return response([
				'message' => 'Se elimino el mobiliario de la oficina con éxito'
			], 204);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Se eliminó el mobiliario con éxito'
			], 204);
		}
	}

}
