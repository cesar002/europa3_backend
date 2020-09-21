<?php

namespace App\Repositories;

use App\Interfaces\IMobiliarioDao;
use App\Mobiliario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MobiliarioRepository implements IMobiliarioDao{

	public function getAll(){
		try {

			$mobiliarioM = Mobiliario::with('tipo', 'pathImages', 'pathImages.pathMaster','edificio', 'edificio.municipio', 'edificio.municipio.estado')->get();

			$mobiliarios = $mobiliarioM->map(function($mobiliario){
				$path = "{$mobiliario->pathImages->pathMaster->path}/{$mobiliario->pathImages->path}/{$mobiliario->image}";
				return [
					'id' => $mobiliario->id,
					'nombre' => $mobiliario->nombre,
					'marca' => $mobiliario->marca,
					'modelo' => $mobiliario->modelo,
					'color' => $mobiliario->color,
					'tipo' => [
						'id' => $mobiliario->tipo->id,
						'nombre' => $mobiliario->tipo->tipo,
					],
					'descripcion' => $mobiliario->descripcion_bien,
					'observaciones'  => $mobiliario->getDescripcion(),
					'cantidad' => $mobiliario->cantidad,
					'activo' => $mobiliario->activo,
					'image' => asset(Storage::url($path)),
					'edificio' => [
						'id' => $mobiliario->edificio->id,
						'nombre' => $mobiliario->edificio->nombre,
						'ubicacion' => [
							'estado' => [
								'id' => $mobiliario->edificio->municipio->estado->id,
								'nombre' => $mobiliario->edificio->municipio->estado->nombre,
							],
							'municipio' => [
								'id' => $mobiliario->edificio->municipio->id,
								'nombre' => $mobiliario->edificio->municipio->nombre,
							],
						],
					],
				];
			});

			return $mobiliarios;
		} catch (\Throwable $th) {
			return [];
		}
	}


	public function getAllByEdificioId($edificioId){
		try {
			$mobiliarioB = DB::select('SELECT DISTINCT mob.*, tm.tipo AS tipo_nombre, e.id AS edi_id, e.nombre AS edi_nombre, mun.id AS mun_id, mun.nombre AS mun_nombre,
											es.id AS es_id, es.nombre AS es_nombre, pim.path AS path_image, pm.path AS path_root
										FROM mobiliarios AS mob
											INNER JOIN tipos_mobiliario AS tm ON tm.id = mob.tipo_id
											INNER JOIN edificios AS e ON e.id = mob.edificio_id
											INNER JOIN municipios AS mun ON mun.id = e.municipio_id
											INNER JOIN estados AS es ON es.id = mun.estado_id
											INNER JOIN path_images AS pim ON pim.id = mob.path_id
											INNER JOIN paths_master AS pm ON pm.id = pim.path_master_id
										WHERE e.id = ?', [$edificioId]);

			$mobiliarios = collect($mobiliarioB)->map(function($mobiliario){
				$image = "{$mobiliario->path_root}/{$mobiliario->path_image}/{$mobiliario->image}";
				return [
					'id' => $mobiliario->id,
					'nombre' => $mobiliario->nombre,
					'marca' => $mobiliario->marca,
					'modelo' => $mobiliario->modelo,
					'color' => $mobiliario->color,
					'tipo' => [
						'id' => $mobiliario->tipo_id,
						'nombre' => $mobiliario->tipo_nombre,
					],
					'descripcion' => $mobiliario->descripcion_bien,
					'observaciones'  => $mobiliario->observaciones ?? '',
					'cantidad' => $mobiliario->cantidad,
					'activo' => boolval($mobiliario->activo),
					'image' => asset(Storage::url($image)),
					'edificio' => [
						'id' => $mobiliario->edi_id,
						'nombre' => $mobiliario->edi_nombre,
						'ubicacion' => [
							'estado' => [
								'id' => $mobiliario->es_id,
								'nombre' => $mobiliario->es_nombre,
							],
							'municipio' => [
								'id' => $mobiliario->mun_id,
								'nombre' => $mobiliario->mun_nombre,
							],
						],
					],
				];
			});

			return $mobiliarios;
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getById($id){
		try {
			$mobiliarioM = Mobiliario::with('tipo', 'edificio', 'edificio.municipio', 'edificio.municipio.estado')->findOrFail($id);

			$mobiliario = $mobiliarioM->map(function($mobiliario){
				return [
					'id' => $mobiliario->id,
					'marca' => $mobiliario->marca,
					'modelo' => $mobiliario->modelo,
					'color' => $mobiliario->color,
					'tipo' => [
						'id' => $mobiliario->tipo->id,
						'nombre' => $mobiliario->tipo->tipo,
					],
					'descripcion' => $mobiliario->descripcion_bien,
					'observaciones'  => $mobiliario->observaciones,
					'activo' => $mobiliario->activo,
					'images' => [],
					'edificio' => [
						'id' => $mobiliario->edificio->id,
						'nombre' => $mobiliario->edificio->nombre,
						'ubicacion' => [
							'estado' => [
								'id' => $mobiliario->edificio->municipio->estado->id,
								'nombre' => $mobiliario->edificio->municipio->estado->nombre,
							],
							'municipio' => [
								'id' => $mobiliario->edificio->municipio->id,
								'nombre' => $mobiliario->edificio->municipio->nombre,
							],
						],
					],
				];
			});

			return $mobiliario;
		} catch (\Throwable $th) {
			return [];
		}
	}

}
