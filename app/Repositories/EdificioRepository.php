<?php

namespace App\Repositories;

use App\Edificio;
use App\Interfaces\IEdificioDao;
use Illuminate\Support\Facades\DB;

class EdificioRepository implements IEdificioDao{

	public function getEdificioById(int $id){
		try {
			$edificio = Edificio::with('municipio', 'municipio.estado')->findOrFail($id);

			return [
				'id' => $edificio->id,
				'nombre' => $edificio->nombre,
				'municipio' => [
					'municipio' => [
						'id' => $edificio->municipio->id,
						'nombre' => $edificio->municipio->nombre
					],
					'estado' => [
						'id' => $edificio->municipio->estado->id,
						'nombre' => $edificio->municipio->estado->nombre,
					],
				],
				'direccion' => $edificio->direccion,
				'telefono_1' => $edificio->telefono_1,
				'telefono_2' => $edificio->telefono_2,
				'telefono_recepcion' => $edificio->telefono_recepcion,
				'coords' => [
					'lat' => $edificio->lat,
					'lon' => $edificio->lon,
				],
				'horas_servicio' => [
					'apertura' => $edificio->hora_apertura,
					'cierre' => $edificio->hora_cierre,
				]
			];
		} catch (\Throwable $th) {
			return [];
		}
	}


	public function getAllEdificios(){
		$edificiosM = Edificio::with('municipio', 'municipio.estado', 'idiomas')->get();

		$edificios = $edificiosM->map(function($edificio){
			return [
				'id' => $edificio->id,
				'nombre' => $edificio->nombre,
				'municipio' => [
					'municipio' => [
						'id' => $edificio->municipio->id,
						'nombre' => $edificio->municipio->nombre
					],
					'estado' => [
						'id' => $edificio->municipio->estado->id,
						'nombre' => $edificio->municipio->estado->nombre,
					],
				],
				'direccion' => $edificio->direccion,
				'telefono_1' => $edificio->telefono_1,
				'telefono_2' => $edificio->telefono_2,
				'telefono_recepcion' => $edificio->telefono_recepcion,
				'coords' => [
					'lat' => $edificio->lat,
					'lon' => $edificio->lon,
				],
				'horas_servicio' => [
					'apertura' => $edificio->hora_apertura,
					'cierre' => $edificio->hora_cierre,
				],
				'idiomas_atencion' => $edificio->idiomas
			];
		});

		return $edificios;
	}


	public function getAllEdificiosByEstadoId(int $estadoId){
		try {
			$edificiosT = DB::select('SELECT e.*,m.id AS municipio_id, m.nombre AS municipio, es.id AS estado_id, es.nombre AS estado FROM edificios AS e
											INNER JOIN municipios AS m ON m.id = e.municipio_id
											INNER JOIN estados AS es ON es.id = m.estado_id
										WHERE es.id = ?', [$estadoId]);

			$edificios = collect($edificiosT)->map(function($edificio){
				return [
					'id' => $edificio->id,
					'nombre' => $edificio->nombre,
					'municipio' => [
						'municipio' => [
							'id' => $edificio->municipio_id,
							'nombre' => $edificio->municipio,
						],
						'estado' => [
							'id' => $edificio->estado_id,
							'nombre' => $edificio->estado,
						],
					],
					'direccion' => $edificio->direccion,
					'telefono_1' => $edificio->telefono_1,
					'telefono_2' => $edificio->telefono_2,
					'telefono_recepcion' => $edificio->telefono_recepcion,
					'coords' => [
						'lat' => $edificio->lat,
						'lon' => $edificio->lon,
					],
					'horas_servicio' => [
						'apertura' => $edificio->hora_apertura,
						'cierre' => $edificio->hora_cierre,
					]
				];
			});

			return $edificios;
		} catch (\Throwable $th) {
			return [];
		}
	}


	public function getAllEdificiosByMunicipioId(int $municipioId){
		try {
			$edificiosT = DB::select('SELECT e.*,m.id AS municipio_id, m.nombre AS municipio, es.id AS estado_id, es.nombre AS estado FROM edificios AS e
											INNER JOIN municipios AS m ON m.id = e.municipio_id
											INNER JOIN estados AS es ON es.id = m.estado_id
										WHERE m.id = ?', [$municipioId]);

			$edificios = collect($edificiosT)->map(function($edificio){
				return [
					'id' => $edificio->id,
					'nombre' => $edificio->nombre,
					'municipio' => [
						'municipio' => [
							'id' => $edificio->municipio_id,
							'nombre' => $edificio->municipio,
						],
						'estado' => [
							'id' => $edificio->estado_id,
							'nombre' => $edificio->estado,
						],
					],
					'direccion' => $edificio->direccion,
					'telefono_1' => $edificio->telefono_1,
					'telefono_2' => $edificio->telefono_2,
					'telefono_recepcion' => $edificio->telefono_recepcion,
					'coords' => [
						'lat' => $edificio->lat,
						'lon' => $edificio->lon,
					],
					'horas_servicio' => [
						'apertura' => $edificio->hora_apertura,
						'cierre' => $edificio->hora_cierre,
					]
				];
			});

			return $edificios;
		} catch (\Throwable $th) {
			return [];
		}
	}


	public function getAllEdificiosByEstadoIdAndMunicipioId(int $estadoId, int $municipioId){
		try {
			$edificiosT = DB::select('SELECT e.*,m.id AS municipio_id, m.nombre AS municipio, es.id AS estado_id, es.nombre AS estado FROM edificios AS e
											INNER JOIN municipios AS m ON m.id = e.municipio_id
											INNER JOIN estados AS es ON es.id = m.estado_id
										WHERE es.id = ? AND m.id = ?', [$estadoId, $municipioId]);

			$edificios = collect($edificiosT)->map(function($edificio){
				return [
					'id' => $edificio->id,
					'nombre' => $edificio->nombre,
					'municipio' => [
						'municipio' => [
							'id' => $edificio->municipio_id,
							'nombre' => $edificio->municipio,
						],
						'estado' => [
							'id' => $edificio->estado_id,
							'nombre' => $edificio->estado,
						],
					],
					'direccion' => $edificio->direccion,
					'telefono_1' => $edificio->telefono_1,
					'telefono_2' => $edificio->telefono_2,
					'telefono_recepcion' => $edificio->telefono_recepcion,
					'coords' => [
						'lat' => $edificio->lat,
						'lon' => $edificio->lon,
					],
					'horas_servicio' => [
						'apertura' => $edificio->hora_apertura,
						'cierre' => $edificio->hora_cierre,
					]
				];
			});

			return $edificios;
		} catch (\Throwable $th) {
			return [];
		}
	}


}
