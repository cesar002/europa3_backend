<?php

namespace App\Http\Controllers;

use App\UserDatoPersonal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DatosPersonalesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\DatosPersonalesStoreRequest $request)
    {
		try {
			$user = $request->user();

			$datosPersonales = new UserDatoPersonal([
				'user_id' => $user->id,
				'nacionalidad_id' => $request->nacionalidad_id,
				'nombre' => $request->nombre,
				'ape_p' => $request->apellido_p,
				'ape_m' => $request->apellido_m,
				'RFC' => strtoupper($request->rfc),
				'CURP' => strtoupper($request->curp),
				'fecha_nacimiento' => $request->fecha_nacimiento,
				'telefono' => $request->telefono,
				'celular' => $request->celular,
				'domicilio' => $request->domicilio,
			]);

			$datosPersonales->save();

			return response([
				'message' => 'Información guardada éxitosamente'
			], 201);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'no se pudo registrar la información personal del usuario'
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
    public function update(\App\Http\Requests\DatosPersonalesUpdateRequest $request){
        try {
			$infoPersonal = UserDatoPersonal::where('user_id', $request->user()->id)->firstOrFail();

			$infoPersonal->nacionalidad_id = $request->nacionalidad_id;
			$infoPersonal->nombre = $request->nombre;
			$infoPersonal->ape_p = $request->apellido_p;
			$infoPersonal->ape_m = $request->apellido_m;
			$infoPersonal->RFC = strtoupper($request->rfc);
			$infoPersonal->CURP = strtoupper($request->curp);
			$infoPersonal->fecha_nacimiento = $request->fecha_nacimiento;
			$infoPersonal->telefono = $request->telefono;
			$infoPersonal->celular = $request->celular;
			$infoPersonal->domicilio = $request->domicilio;

			$infoPersonal->save();

			return response([
				'message' => 'Información actualizada con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'no se pudo actualizar la información personal'
			], 500);
		}
    }
}