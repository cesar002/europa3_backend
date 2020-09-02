<?php

namespace App\Http\Controllers;

use App\Oficina;
use App\Repositories\OficinaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OficinasController extends Controller
{

	private $oficinaRepository;

	public function __construct(OficinaRepository $oficinaRepository){
		$this->oficinaRepository = $oficinaRepository;
	}

	public function getOficinas(){
		$oficinas = $this->oficinaRepository->getAllOficinas();

		return $oficinas;
	}

	public function getOficinasByMunicipio($municipioId){
		$oficinas = $this->oficinaRepository->getOficinasByMunicipioId($municipioId);

		return $oficinas;
	}

	public function getOficinasByEstado($estadoId){
		$oficinas = $this->oficinaRepository->getOficinasByEstadoId($estadoId);

		return $oficinas;
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\OficinaStoreRequest $request){
        try {

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
			]);

			$oficina->save();

			return response([
				'message' => 'Oficina registrada con éxito'
			], 201);
		} catch (\Throwable $th) {

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
			$oficina = Oficina::findOrFail($id);

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

			return response([
				'message' => 'Oficina actualizada con éxito'
			]);
		} catch (\Throwable $th) {
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
