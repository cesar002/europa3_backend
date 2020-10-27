<?php

namespace App\Http\Controllers;

use App\MobiliarioSala;
use App\PathImage;
use App\PathMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Repositories\SalaJuntasRepository;
use App\SalaImage;
use App\SalaJuntas;
use App\SalaServicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SalaJuntaController extends Controller{

	private $salaJuntasRepository = null;

	public function __construct(SalaJuntasRepository $salaJuntasRepository) {
		$this->salaJuntasRepository = $salaJuntasRepository;
	}

	public function index(){
		$data = $this->salaJuntasRepository->getAllSalaJuntas();

		return response($data);
	}

	public function show($id){
		$data = $this->salaJuntasRepository->getSalaJuntaById($id);

		return response(json_encode($data, JSON_FORCE_OBJECT));
	}

	public function store(\App\Http\Requests\SalaJuntaStoreRequest $request){
		try {
			DB::beginTransaction();

			$images = $request->images;
			$pathMaster = PathMaster::findOrFail(2);

			$pathImage = new PathImage([
				'path_master_id' => 2,
				'nombre' => "Sala de juntas - {$request->nombre}",
				'path' => Str::random(rand(10, 50)),
			]);
			$pathImage->save();

			$salaJuntas = new SalaJuntas([
				'edificio_id' => $request->edificio_id,
				'tipo_oficina_id' => 2,
				'size_id' => $request->size_id,
				'nombre' => $request->nombre,
				'descripcion' => $request->descripcion,
				'size_dimension' => $request->size_dimension,
				'capacidad_recomendada' => $request->capacidad_recomendada,
				'capacidad_maxima' => $request->capacidad_maxima,
				'precio' => $request->precio,
				'path_image_id' => $pathImage->id,
				'tipo_tiempo_id' => $request->tipo_tiempo_id,
			]);
			$salaJuntas->save();

			Storage::disk('public')->makeDirectory("{$pathMaster->path}/{$pathImage->path}");

			if(!is_null($images)){
				foreach($images as $image){
					$nameImage = Storage::disk('public')->put("$pathMaster->path/$pathImage->path", $image);

					$imageSala = new SalaImage([
						'sala_juntas_id' => $salaJuntas->id,
						'image' => basename($nameImage),
					]);

					$imageSala->save();
				}
			}

			foreach($request->mobiliario as $mobiliarioId){
				$mob = new MobiliarioSala([
					'sala_juntas_id' => $salaJuntas->id,
					'mobiliario_id' => $mobiliarioId,
				]);

				$mob->save();
			}

			foreach($request->servicios as $servicioId){
				$serv = new SalaServicio([
					'sala_juntas_id' => $salaJuntas->id,
					'servicio_id' => $servicioId,
				]);

				$serv->save();
			}

			DB::commit();

			return response([
				'message' => 'Sala de juntas registrada con éxito',
			], 201);
		} catch (\Throwable $th) {
			DB::rollBack();

			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al intentar registrar la sala de juntas'
			], 500);
		}
	}

	public function update(\App\Http\Requests\SalaJuntaUpdateRequest $request, $id){
		try {
			DB::beginTransaction();

			$salaJuntas = SalaJuntas::findOrFail($id);

			DB::delete('DELETE FROM sala_juntas_servicios WHERE sala_juntas_id = ?', [$id]);
			DB::delete('DELETE FROM mobiliario_sala_juntas WHERE sala_juntas_id = ?', [$id]);


			foreach($request->servicios as $servicio){
				$serv = new SalaServicio([
					'sala_juntas_id' => $salaJuntas->id,
					'servicio_id' => $servicio,
				]);

				$serv->save();
			}

			foreach($request->mobiliario as $mobiliario){
				$mob = new MobiliarioSala([
					'sala_juntas_id' => $salaJuntas->id,
					'mobiliario_id' => $mobiliario,
				]);

				$mob->save();
			}

			$salaJuntas->edificio_id = $request->edificio_id;
			$salaJuntas->size_id = $request->size_id;
			$salaJuntas->tipo_tiempo_id = $request->tipo_tiempo_id;
			$salaJuntas->nombre = $request->nombre;
			$salaJuntas->descripcion = $request->descripcion;
			$salaJuntas->size_dimension = $request->size_dimension;
			$salaJuntas->capacidad_recomendada = $request->capacidad_recomendada;
			$salaJuntas->capacidad_maxima = $request->capacidad_maxima;
			$salaJuntas->precio = $request->precio;

			$salaJuntas->save();

			DB::commit();

			return response([
				'message' => 'Sala de juntas actualizada con éxito',
			]);
		} catch (\Throwable $th) {
			DB::rollBack();

			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al intentar actualizar la sala de juntas'
			], 500);
		}
	}


}
