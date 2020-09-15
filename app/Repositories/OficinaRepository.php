<?php

namespace App\Repositories;

use App\Interfaces\IOficinaDao;
use App\Oficina;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OficinaRepository implements IOficinaDao{

	public function getAllOficinas(){
		try {
			$oficinasM = Oficina::with('pathImages', 'pathImages.pathMaster', 'edificio', 'edificio.municipio', 'edificio.municipio.estado','imagenes', 'tipoOficina', 'size')->get();

			$oficinas = $oficinasM->map(function($oficina){
				$pathImage = "{$oficina->pathImages->pathMaster->path}/{$oficina->pathImages->path}";

				return [
					'id' => $oficina->id,
					'nombre' => $oficina->nombre,
					'descripcion' => $oficina->descripcion,
					'size' => $oficina->size_dimension,
					'precio' => $oficina->precio,
					'size_tipo' => [
						'id' => $oficina->size->id,
						'tipo' => $oficina->size->size_name,
					],
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
					'capacidad' => [
						'recomendada' => $oficina->capacidad_recomendada,
						'maxima' => $oficina->capacidad_maxima
					],
					'tipo_oficina' => [
						'id' => $oficina->tipoOficina->id,
						'tipo' => $oficina->tipoOficina->tipo,
					],
					'images' => $oficina->imagenes->map(function($image) use ($pathImage) {
						return[
							'id' => $image->id,
							'uri' => Storage::url("{$pathImage}/{$image->image}")
						];
					}),
					'status_uso' => $oficina->en_uso
				];
			});

			return $oficinas;
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getOficinaById($id){
		try {
			$oficina = Oficina::with('pathImages', 'pathImages.pathMaster', 'edificio', 'edificio.municipio', 'edificio.municipio.estado','imagenes', 'tipoOficina', 'size')->findOrFail($id);
			$pathImage = "{$oficina->pathImages->pathMaster->path}/{$oficina->pathImages->path}";

			return [
				'id' => $oficina->id,
				'nombre' => $oficina->nombre,
				'descripcion' => $oficina->descripcion,
				'size' => $oficina->size_dimension,
				'precio' => $oficina->precio,
				'size_tipo' => [
					'id' => $oficina->size->id,
					'tipo' => $oficina->size->size_name,
				],
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
				'capacidad' => [
					'recomendada' => $oficina->capacidad_recomendada,
					'maxima' => $oficina->capacidad_maxima
				],
				'tipo_oficina' => [
					'id' => $oficina->tipoOficina->id,
					'tipo' => $oficina->tipoOficina->tipo,
				],
				'images' => $oficina->imagenes->map(function($image) use ($pathImage) {
					return[
						'id' => $image->id,
						'uri' => asset(Storage::url("{$pathImage}/{$image->image}")),
					];
				}),
				'status_uso' => $oficina->en_uso
			];
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getOficinasByEdificioId($edificioId){
		try {
			$oficinasDB = DB::select('SELECT of.*,
									ed.id AS edificio_id, ed.nombre AS edificio_nombre, ed.direccion, ed.telefono_1, ed.telefono_2, ed.telefono_recepcion,
									ed.lat, ed.lon, ed.hora_apertura, ed.hora_cierre,
									cto.id AS tipo_id, cto.tipo,
									cso.id AS size_id, cso.size_name, mu.id AS municipio_id, mu.nombre AS municipio, es.id AS estado_id, es.nombre AS estado
									FROM oficinas AS of
										INNER JOIN edificios AS ed ON ed.id = of.edificio_id
										INNER JOIN cat_tipos_oficina AS cto ON cto.id = of.tipo_oficina_id
										INNER JOIN cat_size_oficinas AS cso ON cso.id = of.size_id
										INNER JOIN municipios AS mu ON mu.id = ed.municipio_id
										INNER JOIN estados AS es ON es.id = mu.estado_id
									WHERE ed.id = ?', [$edificioId]);

			$oficinas = collect($oficinasDB)->map(function($oficina){
				return [
					'id' => $oficina->id,
					'nombre' => $oficina->nombre,
					'descripcion' => $oficina->descripcion,
					'size' => $oficina->size_dimension,
					'precio' => $oficina->precio,
					'size_tipo' => [
						'id' => $oficina->size_id,
						'tipo' => $oficina->size_name,
					],
					'edificio' => [
						'id' => $oficina->edificio_id,
						'nombre' => $oficina->edificio_nombre,
						'municipio' => [
							'id' => $oficina->municipio_id,
							'nombre' => $oficina->municipio,
						],
						'estado' => [
							'id' => $oficina->estado_id,
							'nombre' => $oficina->estado,
						],
						'direccion' => $oficina->direccion,
						'telefono_1' => $oficina->telefono_1,
						'telefono_2' => $oficina->telefono_2,
						'telefono_recepcion' => $oficina->telefono_recepcion,
						'hora_apertura' => $oficina->hora_apertura,
						'hora_cierre' => $oficina->hora_cierre,
						'coords' => [
							'lat' => $oficina->lat,
							'lon' => $oficina->lon,
						],
					],
					'capacidad' => [
						'recomendada' => $oficina->capacidad_recomendada,
						'maxima' => $oficina->capacidad_maxima
					],
					'tipo_oficina' => [
						'id' => $oficina->tipo_id,
						'tipo' => $oficina->tipo,
					],
					'images' => [],
					'status_uso' => boolval($oficina->en_uso),
				];
			});

			return $oficinas;
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getOficinasByEstadoId($estadoId){
		try {
			$oficinasDB = DB::select('SELECT of.*,
										ed.id AS edificio_id, ed.nombre AS edificio_nombre, ed.direccion, ed.telefono_1, ed.telefono_2, ed.telefono_recepcion,
										ed.lat, ed.lon, ed.hora_apertura, ed.hora_cierre,
										cto.id AS tipo_id, cto.tipo,
										cso.id AS size_id, cso.size_name, mu.id AS municipio_id, mu.nombre AS municipio, es.id AS estado_id, es.nombre AS estado
										FROM oficinas AS of
											INNER JOIN edificios AS ed ON ed.id = of.edificio_id
											INNER JOIN cat_tipos_oficina AS cto ON cto.id = of.tipo_oficina_id
											INNER JOIN cat_size_oficinas AS cso ON cso.id = of.size_id
											INNER JOIN municipios AS mu ON mu.id = ed.municipio_id
											INNER JOIN estados AS es ON es.id = mu.estado_id
										WHERE es.id = ?', [$estadoId]);

			$oficinas = collect($oficinasDB)->map(function($oficina){
				return [
					'id' => $oficina->id,
					'nombre' => $oficina->nombre,
					'descripcion' => $oficina->descripcion,
					'size' => $oficina->size_dimension,
					'precio' => $oficina->precio,
					'size_tipo' => [
						'id' => $oficina->size_id,
						'tipo' => $oficina->size_name,
					],
					'edificio' => [
						'id' => $oficina->edificio_id,
						'nombre' => $oficina->edificio_nombre,
						'municipio' => [
							'id' => $oficina->municipio_id,
							'nombre' => $oficina->municipio,
						],
						'estado' => [
							'id' => $oficina->estado_id,
							'nombre' => $oficina->estado,
						],
						'direccion' => $oficina->direccion,
						'telefono_1' => $oficina->telefono_1,
						'telefono_2' => $oficina->telefono_2,
						'telefono_recepcion' => $oficina->telefono_recepcion,
						'hora_apertura' => $oficina->hora_apertura,
						'hora_cierre' => $oficina->hora_cierre,
						'coords' => [
							'lat' => $oficina->lat,
							'lon' => $oficina->lon,
						],
					],
					'capacidad' => [
						'recomendada' => $oficina->capacidad_recomendada,
						'maxima' => $oficina->capacidad_maxima
					],
					'tipo_oficina' => [
						'id' => $oficina->tipo_id,
						'tipo' => $oficina->tipo,
					],
					'images' => [],
					'status_uso' => boolval($oficina->en_uso),
				];
			});

			return $oficinas;
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getOficinasByMunicipioId($municipioId){
		try {
			$oficinasDB = DB::select('SELECT of.*,
							ed.id AS edificio_id, ed.nombre AS edificio_nombre, ed.direccion, ed.telefono_1, ed.telefono_2, ed.telefono_recepcion,
							ed.lat, ed.lon, ed.hora_apertura, ed.hora_cierre,
							cto.id AS tipo_id, cto.tipo,
							cso.id AS size_id, cso.size_name, mu.id AS municipio_id, mu.nombre AS municipio, es.id AS estado_id, es.nombre AS estado
							FROM oficinas AS of
								INNER JOIN edificios AS ed ON ed.id = of.edificio_id
								INNER JOIN cat_tipos_oficina AS cto ON cto.id = of.tipo_oficina_id
								INNER JOIN cat_size_oficinas AS cso ON cso.id = of.size_id
								INNER JOIN municipios AS mu ON mu.id = ed.municipio_id
								INNER JOIN estados AS es ON es.id = mu.estado_id
							WHERE mu.id = ?', [$municipioId]);

			$oficinas = collect($oficinasDB)->map(function($oficina){
				return [
					'id' => $oficina->id,
					'nombre' => $oficina->nombre,
					'descripcion' => $oficina->descripcion,
					'size' => $oficina->size_dimension,
					'precio' => $oficina->precio,
					'size_tipo' => [
						'id' => $oficina->size_id,
						'tipo' => $oficina->size_name,
					],
					'edificio' => [
						'id' => $oficina->edificio_id,
						'nombre' => $oficina->edificio_nombre,
						'municipio' => [
							'id' => $oficina->municipio_id,
							'nombre' => $oficina->municipio,
						],
						'estado' => [
							'id' => $oficina->estado_id,
							'nombre' => $oficina->estado,
						],
						'direccion' => $oficina->direccion,
						'telefono_1' => $oficina->telefono_1,
						'telefono_2' => $oficina->telefono_2,
						'telefono_recepcion' => $oficina->telefono_recepcion,
						'hora_apertura' => $oficina->hora_apertura,
						'hora_cierre' => $oficina->hora_cierre,
						'coords' => [
							'lat' => $oficina->lat,
							'lon' => $oficina->lon,
						],
					],
					'capacidad' => [
						'recomendada' => $oficina->capacidad_recomendada,
						'maxima' => $oficina->capacidad_maxima
					],
					'tipo_oficina' => [
						'id' => $oficina->tipo_id,
						'tipo' => $oficina->tipo,
					],
					'images' => [],
					'status_uso' => boolval($oficina->en_uso),
				];
			});

			return $oficinas;
		} catch (\Throwable $th) {
			return [];
		}
	}

}
