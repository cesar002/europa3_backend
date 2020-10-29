<?php

namespace App\Http\Controllers;

use App\UserDatosMorales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DatosMoralesController extends Controller
{
	private $datosMoralesRepository;

	public function __construct(\App\Repositories\DatosMoralesRepository $datosMoralesRepository){
		$this->datosMoralesRepository = $datosMoralesRepository;
	}

	public function getFromCurrentUser(Request $request){
		$data = $this->datosMoralesRepository->getDatosMoralesByUserId($request->user()->id);

		return response(json_encode($data, JSON_FORCE_OBJECT));
	}

	public function show(){

	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\DatosMoralesStoreRequest $request){
        try {

			$datosMorales = new UserDatosMorales([
				'user_id' => $request->user()->id,
				'nombre_empresa' => trim($request->nombre_empresa),
				'nombre' => trim($request->nombre),
				'ape_p' => trim($request->apellido_p),
				'ape_m' => trim($request->apellido_m),
				'escritura_publica' => trim($request->escritura),
				'numero_notario' => trim($request->notario),
				'fecha_constitucion' => $request->fecha_constitucion,
				'giro_comercial' => trim($request->giro_comercial),
				'telefono' => trim($request->telefono),
				'email' => trim($request->email)
			]);

			$datosMorales->save();

			return response([
				'message' => 'datos morales guardados éxitosamente'
			], 201);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrio un error al registrar los datos morales'
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
    public function update(\App\Http\Requests\DatosMoralesUpdateRequest $request){
        try {

			$datosMorales = UserDatosMorales::where('user_id', $request->user()->id)->firstOrFail();

			$datosMorales->nombre_empresa = trim($request->nombre_empresa);
			$datosMorales->nombre = trim($request->nombre);
			$datosMorales->ape_p = trim($request->apellido_p);
			$datosMorales->ape_m = trim($request->apellido_m);
			$datosMorales->escritura_publica = trim($request->escritura);
			$datosMorales->numero_notario = trim($request->notario);
			$datosMorales->fecha_constitucion = $request->fecha_constitucion;
			$datosMorales->giro_comercial = trim($request->giro_comercial);
			$datosMorales->telefono = trim($request->telefono);
			$datosMorales->email = trim($request->email);

			$datosMorales->save();

			return response([
				'message' => 'datos morales actualizados con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al intentar actualizar la información'
			], 500);
		}
    }
}
