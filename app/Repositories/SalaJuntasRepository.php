<?php

namespace App\Repositories;

use App\Interfaces\ISalaJuntasDao;
use App\SalaJuntas;


class SalaJuntasRepository implements ISalaJuntasDao{

	public function getAllSalaJuntas(){
		$salas = SalaJuntas::with('edificio', 'tipoOficina', 'size', 'pathImages', 'pathImages.pathMaster',
								'servicios', 'imagenes', 'mobiliario', 'tipoTiempoRenta')->all();

		return $salas->map(function($sala){
			return [
				'id' => $sala->id,
				'nombre' => $sala->nombre,
				'descripcion' => $sala->descripcion,
				'dimension' => $sala->size_dimension,
				'capacidad_recomendada' => $sala->capacidad_recomendada,
				'capacidad_maxima' => $sala->capacidad_maxima,
				'precio' => $sala->precio,
				'en_uso' => $sala->en_uso,
				'edificio' => [
					'id' => $sala->edificio->id,
					'nombre' => $sala->edificio->nombre,
					'direccion' => $sala->edificio->direccion,
					'telefono_1' => $sala->edificio->telefono_1,
					'telefono_2' => $sala->edificio->telefono_2,
					'telefono_recepcion' => $sala->edificio->telefono_recepcion,
					'hora_apertura' => $sala->edificio->hora_apertura,
					'hora_cierre' => $sala->edificio_hora_cierre,
				],
			];
		});
	}

	public function getSalaJuntaById($id){
		try {
			$salas = SalaJuntas::with('edificio', 'tipoOficina', 'size', 'pathImages', 'pathImages.pathMaster',
								'servicios', 'imagenes', 'mobiliario', 'tipoTiempoRenta')->findOrFail($id);

			return $salas->map(function($sala){
				return [
					'id' => $sala->id,
					'nombre' => $sala->nombre,
					'descripcion' => $sala->descripcion,
					'dimension' => $sala->size_dimension,
					'capacidad_recomendada' => $sala->capacidad_recomendada,
					'capacidad_maxima' => $sala->capacidad_maxima,
					'precio' => $sala->precio,
					'en_uso' => $sala->en_uso,
					'edificio' => [
						'id' => $sala->edificio->id,
						'nombre' => $sala->edificio->nombre,
						'direccion' => $sala->edificio->direccion,
						'telefono_1' => $sala->edificio->telefono_1,
						'telefono_2' => $sala->edificio->telefono_2,
						'telefono_recepcion' => $sala->edificio->telefono_recepcion,
						'hora_apertura' => $sala->edificio->hora_apertura,
						'hora_cierre' => $sala->edificio_hora_cierre,
					],
				];
			});
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getSalaJuntasByEdificioId($edificioId){
		try {
			$salas = SalaJuntas::with('edificio', 'tipoOficina', 'size', 'pathImages', 'pathImages.pathMaster',
								'servicios', 'imagenes', 'mobiliario', 'tipoTiempoRenta')->where('edificio_id', $edificioId)->get();

			return $salas->map(function($sala){
				return [
					'id' => $sala->id,
					'nombre' => $sala->nombre,
					'descripcion' => $sala->descripcion,
					'dimension' => $sala->size_dimension,
					'capacidad_recomendada' => $sala->capacidad_recomendada,
					'capacidad_maxima' => $sala->capacidad_maxima,
					'precio' => $sala->precio,
					'en_uso' => $sala->en_uso,
					'edificio' => [
						'id' => $sala->edificio->id,
						'nombre' => $sala->edificio->nombre,
						'direccion' => $sala->edificio->direccion,
						'telefono_1' => $sala->edificio->telefono_1,
						'telefono_2' => $sala->edificio->telefono_2,
						'telefono_recepcion' => $sala->edificio->telefono_recepcion,
						'hora_apertura' => $sala->edificio->hora_apertura,
						'hora_cierre' => $sala->edificio_hora_cierre,
					],
				];
			});
		} catch (\Throwable $th) {
			return [];
		}
	}

}
