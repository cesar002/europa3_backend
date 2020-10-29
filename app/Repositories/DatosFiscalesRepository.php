<?php

namespace App\Repositories;

use App\Interfaces\IDatosFiscalesDao;
use App\UserDatosFiscales;
use Illuminate\Support\Facades\Log;

class DatosFiscalesRepository implements IDatosFiscalesDao{

	public function getDatosFiscalesByUserId($userId){
		try {
			$data = UserDatosFiscales::with('estado', 'municipio')->where('user_id', $userId)->firstOrFail();

			return [
				'id' => $data->id,
				'estado' => [
					'id' => $data->estado->id,
					'nombre' => $data->estado->nombre,
				],
				'municipio' => [
					'id' => $data->municipio->id,
					'nombre' => $data->municipio->nombre,
				],
				'email' => $data->email,
				'razon_social' => $data->razon_social,
				'RFC' => $data->RFC,
				'telefono' => $data->telefono,
				'calle' => $data->calle,
				'numero_exterior' => $data->numero_exterior,
				'numero_interior' => $data->numero_interior,
				'codigo_postal' => $data->codigo_postal,
				'colonia' => $data->colonia,
			];
		} catch (\Throwable $th) {
			return [];
		}
	}

}
