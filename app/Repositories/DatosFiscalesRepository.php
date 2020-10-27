<?php

namespace App\Repositories;

use App\Interfaces\IDatosFiscalesDao;
use App\UserDatosFiscales;

class DatosFiscalesRepository implements IDatosFiscalesDao{

	public function getDatosFiscalesByUserId($userId){
		try {
			$data = UserDatosFiscales::with('estado', 'municipio')->where('user_id', $userId)->firstOrFail();

			return $data->map(function($dato){
				return [
					'id' => $dato->id,
					'estado' => [
						'id' => $dato->estado->id,
						'nombre' => $dato->estado->nombre,
					],
					'municipio' => [
						'id' => $dato->municipio->id,
						'nombre' => $dato->municipio->nombre,
					],
					'email' => $dato->email,
					'razon_social' => $dato->razon_social,
					'RFC' => $dato->RFC,
					'telefono' => $dato->telefono,
					'calle' => $dato->calle,
					'numero_exterior' => $dato->numero_exterior,
					'numero_interior' => $dato->numero_interior,
					'codigo_postal' => $dato->codigo_postal,
					'colonia' => $dato->colonia,
				];
			});
		} catch (\Throwable $th) {
			return [];
		}
	}

}
