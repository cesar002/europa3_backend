<?php

namespace App\Repositories;

use App\Interfaces\ISalaJuntasDao;
use App\SalaJuntas;
use Illuminate\Support\Facades\Storage;

class SalaJuntasRepository implements ISalaJuntasDao{

	public function getAllSalaJuntas(){
		$salas = SalaJuntas::with('edificio', 'edificio.municipio', 'edificio.municipio.estado', 'tipoOficina', 'size', 'pathImages', 'pathImages.pathMaster',
								'servicios', 'imagenes', 'mobiliarioAsignado', 'mobiliarioAsignado.mobiliario', 'tipoTiempoRenta', 'size',
								'mobiliarioAsignado.mobiliario.tipo', 'mobiliarioAsignado.mobiliario.pathImages',  'mobiliarioAsignado.mobiliario.pathImages.pathMaster')->get();

		return $salas->map(function($sala){
			$path = "{$sala->pathImages->pathMaster->path}/{$sala->pathImages->path}";
			$mobiliario = $sala->mobiliarioAsignado;

			return [
				'id' => $sala->id,
				'nombre' => $sala->nombre,
				'descripcion' => $sala->descripcion,
				'dimension' => $sala->size_dimension,
				'size_tipo' => [
					'id' => $sala->size->id,
					'tipo' => $sala->size->size_name,
				],
				'capacidad' => [
					'recomendada' => $sala->capacidad_recomendada,
					'maxima' => $sala->capacidad_maxima
				],
				'tipo_oficina' => [
					'id' => $sala->tipoOficina->id,
					'tipo' => $sala->tipoOficina->tipo,
				],
				'tipo_renta' => [
					'id' => $sala->tipoTiempoRenta->id,
					'tipo' => $sala->tipoTiempoRenta->tiempo,
				],
				'precio' => $sala->precio,
				'edificio' => [
					'id' => $sala->edificio->id,
					'nombre' => $sala->edificio->nombre,
					'municipio' => [
						'id' => $sala->edificio->municipio->id,
						'nombre' => $sala->edificio->municipio->nombre
					],
					'estado' => [
						'id' => $sala->edificio->municipio->estado->id,
						'nombre' => $sala->edificio->municipio->estado->nombre,
					],
					'direccion' => $sala->edificio->direccion,
					'telefono_1' => $sala->edificio->telefono_1,
					'telefono_2' => $sala->edificio->telefono_2,
					'telefono_recepcion' => $sala->edificio->telefono_recepcion,
					'hora_apertura' => $sala->edificio->hora_apertura,
					'hora_cierre' => $sala->edificio->hora_cierre,
					'coords' => [
						'lat' => $sala->edificio->lat,
						'lon' => $sala->edificio->lon,
					],
				],
				'servicios' => $sala->servicios->map(function($servicio){
					return[
						'id' => $servicio->id,
						'servicio' => $servicio->servicio,
					];
				}),
				'mobiliario' => $mobiliario->map(function($mob){
					$pathImage = "{$mob->mobiliario->pathImages->pathMaster->path}/{$mob->mobiliario->pathImages->path}/{$mob->mobiliario->image}";
					return[
						'id' => $mob->mobiliario->id,
						'nombre' => $mob->mobiliario->nombre,
						'marca' => $mob->mobiliario->marca,
						'modelo' => $mob->mobiliario->modelo,
						'color' => $mob->mobiliario->color,
						'image' => asset(Storage::url($pathImage)),
						'tipo' => [
							'id' => $mob->mobiliario->tipo->id,
							'nombre' => $mob->mobiliario->tipo->tipo,
						],
						'cantidad' => $mob->cantidad,
					];
				})->unique('id')->values()->all(),
				'images' => $sala->imagenes->map(function($img) use($path){
					return[
						'id' => $img->id,
						'url' => asset(Storage::url("$path/{$img->image}")),
					];
				}),
				'status_uso' => $sala->en_uso,
			];
		});
	}

	public function getSalaJuntaById($id){
		try {
			$salas = SalaJuntas::with('edificio', 'edificio.municipio', 'edificio.municipio.estado', 'tipoOficina', 'size', 'pathImages', 'pathImages.pathMaster',
								'servicios', 'imagenes', 'mobiliario', 'tipoTiempoRenta', 'size',
								'mobiliario.tipo', 'mobiliario.pathImages',  'mobiliario.pathImages.pathMaster')->findOrFail($id);

			return $salas->map(function($sala){
				$path = "{$sala->pathImages->pathMaster->path}/{$sala->pathImages->path}";
				$mobiliario = $sala->mobiliario;

				return [
					'id' => $sala->id,
					'nombre' => $sala->nombre,
					'descripcion' => $sala->descripcion,
					'dimension' => $sala->size_dimension,
					'size_tipo' => [
						'id' => $sala->size->id,
						'tipo' => $sala->size->size_name,
					],
					'capacidad' => [
						'recomendada' => $sala->capacidad_recomendada,
						'maxima' => $sala->capacidad_maxima
					],
					'tipo_oficina' => [
						'id' => $sala->tipoOficina->id,
						'tipo' => $sala->tipoOficina->tipo,
					],
					'tipo_renta' => [
						'id' => $sala->tipoTiempoRenta->id,
						'tipo' => $sala->tipoTiempoRenta->tiempo,
					],
					'precio' => $sala->precio,
					'en_uso' => $sala->en_uso,
					'edificio' => [
						'id' => $sala->edificio->id,
						'nombre' => $sala->edificio->nombre,
						'municipio' => [
							'id' => $sala->edificio->municipio->id,
							'nombre' => $sala->edificio->municipio->nombre
						],
						'estado' => [
							'id' => $sala->edificio->municipio->estado->id,
							'nombre' => $sala->edificio->municipio->estado->nombre,
						],
						'direccion' => $sala->edificio->direccion,
						'telefono_1' => $sala->edificio->telefono_1,
						'telefono_2' => $sala->edificio->telefono_2,
						'telefono_recepcion' => $sala->edificio->telefono_recepcion,
						'hora_apertura' => $sala->edificio->hora_apertura,
						'hora_cierre' => $sala->edificio->hora_cierre,
						'coords' => [
							'lat' => $sala->edificio->lat,
							'lon' => $sala->edificio->lon,
						],
					],
					'servicios' => $sala->servicios->map(function($servicio){
						return[
							'id' => $servicio->id,
							'servicio' => $servicio->servicio,
						];
					}),
					'mobiliario' => $mobiliario->map(function($mob) use($mobiliario){
						$pathImage = "{$mob->pathImages->pathMaster->path}/{$mob->pathImages->path}/{$mob->image}";
						return[
							'id' => $mob->id,
							'nombre' => $mob->nombre,
							'marca' => $mob->marca,
							'modelo' => $mob->modelo,
							'color' => $mob->color,
							'image' => asset(Storage::url($pathImage)),
							'tipo' => [
								'id' => $mob->tipo->id,
								'nombre' => $mob->tipo->tipo,
							],
							'cantidad' => collect($mobiliario->filter(function($value, $key) use($mob){ return $value->id == $mob->id;})->all())
											->countBy(function($m) use($mob){ return $m->id == $mob->id; })->values()->all()[0],
						];
					})->unique('id')->values()->all(),
					'images' => $sala->imagenes->map(function($img) use($path){
						return[
							'id' => $img->id,
							'url' => asset(Storage::url("$path/{$img->image}")),
						];
					}),
					'status_uso' => $sala->en_uso,
				];
			});
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getSalaJuntasByEdificioId($edificioId){
		try {
			$salas = SalaJuntas::with('edificio', 'edificio.municipio', 'edificio.municipio.estado', 'tipoOficina', 'size', 'pathImages', 'pathImages.pathMaster',
								'servicios', 'imagenes', 'mobiliario', 'tipoTiempoRenta', 'size',
								'mobiliario.tipo', 'mobiliario.pathImages',  'mobiliario.pathImages.pathMaster')->where('edificio_id', $edificioId)->get();

			return $salas->map(function($sala){
				$path = "{$sala->pathImages->pathMaster->path}/{$sala->pathImages->path}";
				$mobiliario = $sala->mobiliario;

				return [
					'id' => $sala->id,
					'nombre' => $sala->nombre,
					'descripcion' => $sala->descripcion,
					'dimension' => $sala->size_dimension,
					'size_tipo' => [
						'id' => $sala->size->id,
						'tipo' => $sala->size->size_name,
					],
					'capacidad' => [
						'recomendada' => $sala->capacidad_recomendada,
						'maxima' => $sala->capacidad_maxima
					],
					'tipo_oficina' => [
						'id' => $sala->tipoOficina->id,
						'tipo' => $sala->tipoOficina->tipo,
					],
					'tipo_renta' => [
						'id' => $sala->tipoTiempoRenta->id,
						'tipo' => $sala->tipoTiempoRenta->tiempo,
					],
					'precio' => $sala->precio,
					'en_uso' => $sala->en_uso,
					'edificio' => [
						'id' => $sala->edificio->id,
						'nombre' => $sala->edificio->nombre,
						'municipio' => [
							'id' => $sala->edificio->municipio->id,
							'nombre' => $sala->edificio->municipio->nombre
						],
						'estado' => [
							'id' => $sala->edificio->municipio->estado->id,
							'nombre' => $sala->edificio->municipio->estado->nombre,
						],
						'direccion' => $sala->edificio->direccion,
						'telefono_1' => $sala->edificio->telefono_1,
						'telefono_2' => $sala->edificio->telefono_2,
						'telefono_recepcion' => $sala->edificio->telefono_recepcion,
						'hora_apertura' => $sala->edificio->hora_apertura,
						'hora_cierre' => $sala->edificio->hora_cierre,
						'coords' => [
							'lat' => $sala->edificio->lat,
							'lon' => $sala->edificio->lon,
						],
					],
					'servicios' => $sala->servicios->map(function($servicio){
						return[
							'id' => $servicio->id,
							'servicio' => $servicio->servicio,
						];
					}),
					'mobiliario' => $mobiliario->map(function($mob) use($mobiliario){
						$pathImage = "{$mob->pathImages->pathMaster->path}/{$mob->pathImages->path}/{$mob->image}";
						return[
							'id' => $mob->id,
							'nombre' => $mob->nombre,
							'marca' => $mob->marca,
							'modelo' => $mob->modelo,
							'color' => $mob->color,
							'image' => asset(Storage::url($pathImage)),
							'tipo' => [
								'id' => $mob->tipo->id,
								'nombre' => $mob->tipo->tipo,
							],
							'cantidad' => collect($mobiliario->filter(function($value, $key) use($mob){ return $value->id == $mob->id;})->all())
											->countBy(function($m) use($mob){ return $m->id == $mob->id; })->values()->all()[0],
						];
					})->unique('id')->values()->all(),
					'images' => $sala->imagenes->map(function($img) use($path){
						return[
							'id' => $img->id,
							'url' => asset(Storage::url("$path/{$img->image}")),
						];
					}),
					'status_uso' => $sala->en_uso,
				];
			});
		} catch (\Throwable $th) {
			return [];
		}
	}

}
