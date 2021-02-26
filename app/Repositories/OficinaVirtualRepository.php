<?php

namespace App\Repositories;

use App\Interfaces\IOficinaVirtualDao;
use App\OficinaVirtual;
use Illuminate\Support\Facades\Log;

class OficinaVirtualRepository implements IOficinaVirtualDao{

	public function getAll(){
		try {

			$oficinasV = OficinaVirtual::with(
						'servicios', 'edificio', 'edificio.municipio', 'edificio.municipio.estado' ,'tipoOficina'
						)->get();

			$oficinas = $oficinasV->map(function($oficina){
				return [
					'id' => $oficina->id,
					'nombre' => $oficina->nombre,
					'descripcion' => $oficina->descripcion,
					'precio' => $oficina->precio,
					'servicios' => $oficina->servicios,
					'edificio' => [
						'id' => $oficina->edificio->id,
						'nombre' => $oficina->edificio->nombre,
						'municipio' => [
							'id' => $oficina->edificio->municipio->id,
							'nombre' => $oficina->edificio->municipio->nombre
						],
						'estado' => [
							'id' => $oficina->edificio->municipio->estado->id,
							'nombre' => $oficina->edificio->municipio->estado->nombre,
						],
						'direccion' => $oficina->edificio->direccion,
						'telefono_1' => $oficina->edificio->telefono_1,
						'telefono_2' => $oficina->edificio->telefono_2,
						'telefono_recepcion' => $oficina->edificio->telefono_recepcion,
						'hora_apertura' => $oficina->edificio->hora_apertura,
						'hora_cierre' => $oficina->edificio->hora_cierre,
						'coords' => [
							'lat' => $oficina->edificio->lat,
							'lon' => $oficina->edificio->lon,
						],
					],
					'tipo_oficina' => [
						'id' => $oficina->tipoOficina->id,
						'tipo' => $oficina->tipoOficina->tipo,
					],
					'status_uso' => $oficina->en_uso,
				];
			});

			return $oficinas;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return [];
		}
	}

	public function getById($id){
		try {

		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return json_encode([], JSON_FORCE_OBJECT);
		}
	}

	public function getByEdificioId($edificioId){
		try {

		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return [];
		}
	}

}
