<?php

namespace App\Http\Controllers;

use App\MobiliarioOficina;
use App\Oficina;
use App\OficinaImage;
use App\OficinaServicio;
use App\PathImage;
use App\PathMaster;
use App\Repositories\OficinaRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OficinasController extends Controller
{

	private $oficinaRepository;

	public function __construct(OficinaRepository $oficinaRepository){
		$this->oficinaRepository = $oficinaRepository;
	}

	public function getOficinas(){
		$oficinas = $this->oficinaRepository->getAllOficinas();

		return response($oficinas);
	}

	public function getOficinasByMunicipio($municipioId){
		$oficinas = $this->oficinaRepository->getOficinasByMunicipioId($municipioId);

		return response($oficinas);
	}

	public function getOficinasByEstado($estadoId){
		$oficinas = $this->oficinaRepository->getOficinasByEstadoId($estadoId);

		return response($oficinas);
	}

	public function getOficinasByEdificioId($edificioId){
		$oficinas = $this->oficinaRepository->getOficinasByEdificioId($edificioId);

		return response($oficinas);
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\OficinaStoreRequest $request){
        try {

			DB::beginTransaction();

			$images = $request->images;
			$pathMaster = PathMaster::findOrFail(2);

			$pathImage = new PathImage([
				'path_master_id' => 2,
				'nombre' => "Oficina - $request->nombre",
				'path' => Str::random(rand(10, 50)),
			]);

			$pathImage->save();

			$oficina = new Oficina([
				'edificio_id' => $request->edificio_id,
				'tipo_oficina_id' => $request->tipo_oficina_id,
				'size_id' => $request->size_id,
				'nombre' => $request->nombre,
				'descripcion' => $request->descripcion,
				'size_dimension' => $request->dimension,
				'capacidad_recomendada' => $request->capacidad_recomendada,
				'capacidad_maxima' => $request->capacidad_maxima,
				'precio' => $request->precio,
				'path_image_id' => $pathImage->id
			]);

			Storage::disk('public')->makeDirectory("{$pathMaster->path}/{$pathImage->path}");

			$oficina->save();

			if(!is_null($images)){
				foreach($images as $image){
					$nameImage = Storage::disk('public')->put("$pathMaster->path/$pathImage->path", $image);

					$imageOficina = new OficinaImage([
						'oficina_id' => $oficina->id,
						'image' => basename($nameImage),
					]);

					$imageOficina->save();
				}
			}

			foreach($request->mobiliario as $mobiliarioId){
				$mob = new MobiliarioOficina([
					'oficina_id' => $oficina->id,
					'mobiliario_id' => $mobiliarioId,
				]);

				$mob->save();
			}

			foreach($request->servicios as $servicioId){
				$serv = new OficinaServicio([
					'oficina_id' => $oficina->id,
					'servicio_id' => $servicioId,
				]);

				$serv->save();
			}

			DB::commit();

			return response([
				'message' => 'Oficina registrada con éxito'
			], 201);
		} catch (\Throwable $th) {

			DB::rollBack();

			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al registrar la oficina'
			], 500);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$oficina = $this->oficinaRepository->getOficinaById($id);

		return $oficina;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\OficinaUpdateRequest $request, $id)
    {
        try {
			DB::beginTransaction();

			$oficina = Oficina::findOrFail($id);

			DB::delete('DELETE FROM oficina_servicios WHERE oficina_id = ?', [$id]);
			DB::delete('DELETE FROM mobiliario_oficina WHERE oficina_id = ?', [$id]);

			foreach($request->servicios as $servicio){
				$serv = new OficinaServicio([
					'oficina_id' => $oficina->id,
					'servicio_id' => $servicio,
				]);

				$serv->save();
			}

			foreach($request->mobiliario as $mobiliario){
				$mob = new MobiliarioOficina([
					'oficina_id' => $oficina->id,
					'mobiliario_id' => $mobiliario,
				]);

				$mob->save();
			}

			$oficina->edificio_id = $request->edificio_id;
			$oficina->tipo_oficina_id = $request->tipo_oficina_id;
			$oficina->size_id = $request->size_id;
			$oficina->nombre = $request->nombre;
			$oficina->descripcion = $request->descripcion;
			$oficina->size_dimension = $request->dimension;
			$oficina->capacidad_recomendada = $request->capacidad_recomendada;
			$oficina->capacidad_maxima = $request->capacidad_maxima;
			$oficina->precio = $request->precio;

			$oficina->save();


			DB::commit();

			return response([
				'message' => 'Oficina actualizada con éxito'
			]);
		} catch (\Throwable $th) {
			DB::rollBack();

			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al actualizar la oficina'
			], 500);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        try {

			$oficina = Oficina::findOrFail($id);
			$oficina->delete();

			return response([
				'message' => 'Oficina eliminada con éxito'
			], 204);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al eliminar la oficina'
			], 500);
		}
    }
}
