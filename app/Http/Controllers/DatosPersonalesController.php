<?php

namespace App\Http\Controllers;

use App\UserDatoPersonal;
use Carbon\Carbon;
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
				'tipo_identificacion_id' => $request->identificacion_id,
				'nombre' => trim($request->nombre),
				'ape_p' => trim($request->apellido_p),
				'ape_m' => trim($request->apellido_m),
				'tipo_identificacion_otro' => $request->identificacion_id == 5 ? trim($request->identificacion_otro) : null,
				'numero_identificacion' => trim($request->numero_identificacion),
				'RFC' => strtoupper(trim($request->rfc)),
				'CURP' => strtoupper(trim($request->curp)),
				'fecha_nacimiento' => $request->fecha_nacimiento,
				'telefono' => trim($request->telefono),
				'celular' => trim($request->celular),
				'domicilio' => trim($request->domicilio),
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

			$date = $request->fecha_nacimiento;

			$infoPersonal->nacionalidad_id = $request->nacionalidad_id;
			$infoPersonal->tipo_identificacion_id = $request->identificacion_id;
			$infoPersonal->nombre = $request->nombre;
			$infoPersonal->ape_p = $request->apellido_p;
			$infoPersonal->ape_m = $request->apellido_m;
			$infoPersonal->tipo_identificacion_otro = $request->identificacion_otro;
			$infoPersonal->numero_identificacion = $request->numero_identificacion;
			$infoPersonal->RFC = strtoupper($request->rfc);
			$infoPersonal->CURP = strtoupper($request->curp);
			$infoPersonal->fecha_nacimiento = $date;
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
