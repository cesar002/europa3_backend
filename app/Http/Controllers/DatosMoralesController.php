<?php

namespace App\Http\Controllers;

use App\UserDatosMorales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DatosMoralesController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\DatosMoralesStoreRequest $request){
        try {
			$user = $request->user();

			$datosMorales = new UserDatosMorales([
				'user_id' => $user->id,
				'nombre_empresa' => $request->nombre_empresa,
				'nombre' => $request->nombre,
				'ape_p' => $request->apellido_p,
				'ape_m' => $request->apellido_m,
				'escritura_publica' => $request->escritura,
				'numero_notario' => $request->notario,
				'fecha_constitucion' => $request->fecha_constitucion,
				'giro_comercial' => $request->giro_comercial,
				'telefono' => $request->telefono,
				'email' => $request->email
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

			$datosMorales->nombre_empresa = $request->nombre_empresa;
			$datosMorales->nombre = $request->nombre;
			$datosMorales->ape_p = $request->apellido_p;
			$datosMorales->ape_m = $request->apellido_m;
			$datosMorales->escritura_publica = $request->escritura;
			$datosMorales->numero_notario = $request->notario;
			$datosMorales->fecha_constitucion = $request->fecha_constitucion;
			$datosMorales->giro_comercial = $request->giro_comercial;
			$datosMorales->telefono = $request->telefono;
			$datosMorales->email = $request->email;

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
