<?php

namespace App\Http\Controllers;

use App\Edificio;
use App\EdificioIdiomasAtencion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EdificioController extends Controller
{

	private $edificioRepository;

	public function __construct(\App\Repositories\EdificioRepository $edificioRepository){
		$this->edificioRepository = $edificioRepository;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
		$edificios = $this->edificioRepository->getAllEdificios();

		return response($edificios);
	}

	public function getByMunicipioId($municipioId){
		try {
			$edificios = $this->edificioRepository->getAllEdificiosByMunicipioId($municipioId);

			return response($edificios);
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getByEstadoId($estadoId){
		try {
			$edificios = $this->edificioRepository->getAllEdificiosByEstadoId($estadoId);

			return response($edificios);
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getByEstadoIdAndMunicipioId($estadoId, $municipioId){
		try {
			$edificios = $this->edificioRepository->getAllEdificiosByEstadoIdAndMunicipioId($estadoId, $municipioId);

			return response($edificios);
		} catch (\Throwable $th) {
			return [];
		}
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\EdificioStoreRequest $request){
		try {

			DB::beginTransaction();

			$edificio = new Edificio([
				'municipio_id' => $request->municipio_id,
				'nombre' => $request->nombre,
				'direccion' => $request->direccion,
				'telefono_1' => $request->telefono,
				'telefono_2' => $request->telefono_2,
				'telefono_recepcion' => $request->telefono_recepcion,
				'lat' => $request->lat ?? 0,
				'lon' => $request->lon ?? 0,
				'hora_apertura' => $request->hora_apertura,
				'hora_cierre' => $request->hora_cierre
			]);

			$edificio->save();

			foreach($request->idiomas_atencion as $i => $value){
				EdificioIdiomasAtencion::create([
					'edificio_id' => $edificio->id,
					'idioma_id' => $value['id'],
				]);
			}

			DB::commit();

			return response([
				'message' => 'Edifcio registrado con ??xito'
			], 201);
		} catch (\Throwable $th) {
			DB::rollBack();

			Log::error($th->getMessage());

			return response([
				'error' => 'No se logr?? registrar el edificio'
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
		$edificio = $this->edificioRepository->getEdificioById($id);

		return response($edificio);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\EdificioUpdateRequest $request, $id){
		try {
			$edificio = Edificio::findOrFail($id);

			DB::beginTransaction();

			$edificio->nombre = $request->nombre;
			$edificio->municipio_id = $request->municipio_id;
			$edificio->direccion = $request->direccion;
			$edificio->telefono_1 = $request->telefono;
			$edificio->telefono_2 = $request->telefono_2;
			$edificio->telefono_recepcion = $request->telefono_recepcion;
			$edificio->lat = $request->lat ?? 0;
			$edificio->lon = $request->lon ?? 0;
			$edificio->hora_apertura = $request->hora_apertura;
			$edificio->hora_cierre = $request->hora_cierre;

			$edificio->save();

			if(!empty($request->idiomas_atencion)){

				DB::delete('DELETE FROM edificio_idiomas_atencion WHERE edificio_id = ?', [$edificio->id]);

				foreach($request->idiomas_atencion as $i => $value){
					EdificioIdiomasAtencion::create([
						'edificio_id' => $edificio->id,
						'idioma_id' => $value['id'],
					]);
				}
			}

			DB::commit();

			return response([
				'message' => 'Edificio actualizado con ??xito'
			]);
		} catch (\Throwable $th) {

			DB::rollBack();

			Log::error($th->getMessage());

			return response([
				'error' => 'No se pudo actualizar la informaci??n del elemento'
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
			$edificio = Edificio::findOrFail($id);

			$edificio->delete();

			return response([
				'message' => 'Se elimin?? el edificio con ??xico'
			], 204);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'No se pudo eliminar el elemento'
			], 500);
		}
    }
}
