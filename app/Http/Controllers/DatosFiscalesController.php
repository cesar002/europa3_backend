<?php

namespace App\Http\Controllers;

use App\UserDatosFiscales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DatosFiscalesController extends Controller
{

	private $datosFiscalesRepository;

	public function __construct(\App\Repositories\DatosFiscalesRepository $datosFiscalesRepository){
		$this->datosFiscalesRepository = $datosFiscalesRepository;
	}

	public function getFromCurrentUser(Request $request){
		$data = $this->datosFiscalesRepository->getDatosFiscalesByUserId($request->user()->id);

		return response(json_encode($data, JSON_FORCE_OBJECT));
	}


	public function show($userId){

	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\DatosFiscalesStoreRequest $request){
        try {

			$informacionFiscal = new UserDatosFiscales([
				'user_id' => $request->user()->id,
				'estado_id' => $request->estado_id,
				'municipio_id' => $request->municipio_id,
				'email' => $request->email,
				'RFC' => $request->rfc,
				'razon_social' => $request->razon_social,
				'telefono' => $request->telefono,
				'calle' => $request->calle,
				'numero_exterior' => $request->numero_exterior,
				'numero_interior' => $request->numero_interior,
				'codigo_postal' => $request->cp,
				'colonia' => $request->colonia
			]);

			$informacionFiscal->save();

			return response([
				'message' => 'Información registrada con éxito'
			], 201);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'No se pudo registrar la información fiscal del usuario'
			], 500);
		}
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\DatosFiscalesUpdateRequest $request){
        try {
			$informacionFiscal = $request->user()->datosFiscales()->firstOrFail();

			$informacionFiscal->estado_id = $request->estado_id;
			$informacionFiscal->municipio_id = $request->municipio_id;
			$informacionFiscal->email = $request->email;
			$informacionFiscal->razon_social = $request->razon_social;
			$informacionFiscal->RFC = $request->rfc;
			$informacionFiscal->telefono = $request->telefono;
			$informacionFiscal->calle = $request->calle;
			$informacionFiscal->numero_exterior = $request->numero_exterior;
			$informacionFiscal->numero_interior = $request->numero_interior;
			$informacionFiscal->codigo_postal = $request->cp;
			$informacionFiscal->colonia = $request->colonia;

			$informacionFiscal->save();

			return response([
				'message' => 'Se actualizó la información con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al registrar la información fiscal'
			], 500);
		}
    }

}
