<?php

namespace App\Http\Controllers;

use App\AgendaUser;
use App\Http\Requests\AgendaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AgendaController extends Controller
{

	public function index()
	{
		try {
			$user = request()->user();
			$agenda = $user->agendas()->get();

			return response($agenda);
		} catch (\Throwable $th) {
			return response([]);
		}
	}

	public function store(AgendaRequest $request)
	{
		try {

			AgendaUser::create([
				'user_id' => request()->user()->id,
				'fecha_actividad' => $request->fecha_actividad,
				'hora_inicio' => $request->hora_inicio,
				'hora_fin' => $request->hora_fin,
				'titulo' => $request->titulo,
				'descripcion' => $request->descripcion,
			]);

			return response([
				'message' => 'Actividad registrada con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al registrar la actividad en la agenda'
			], 501);
		}
	}

	public function show($id)
	{
		try {

			$agenda = AgendaUser::findOrFail($id);

			return response($agenda);
		} catch (\Throwable $th) {
			return response(json_encode([], JSON_FORCE_OBJECT));
		}
	}

	public function update(AgendaRequest $request, $id)
	{
		try {
			$agenda = AgendaUser::findOrFail($id);

			$agenda->fecha_actividad = $request->fecha_actividad;
			$agenda->hora_actividad = $request->hora_actividad;
			$agenda->titulo = $request->titulo;
			$agenda->descripcion = $request->descripcion;
			$agenda->save();

			return response([
				'message' => 'Actividad actualizada con éxito',
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al actualizar la actividad'
			], 501);
		}
	}

	public function destroy($id)
	{
		try {
			$agenda = AgendaUser::findOrFail($id);

			$agenda->delete();

			return response([
				'message' => 'Actividad eliminada con éxito',
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al eliminar la actividad',
			], 501);
		}
	}

}
