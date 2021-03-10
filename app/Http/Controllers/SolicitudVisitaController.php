<?php

namespace App\Http\Controllers;

use App\Oficina;
use App\SalaJuntas;
use App\OficinaVirtual;
use App\SolicitudVisita;
use App\NotificationAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\SolicitudVisitaCreated;
use App\Events\NotificationAdminSender;
use App\Http\Requests\SolicitudVisitaRequest;

class SolicitudVisitaController extends Controller
{
    public function index()
	{
		$solicitudes = SolicitudVisita::with('solicitudable')->orderBy('created_at', 'desc')->get();

		return response($solicitudes);
	}

	public function store(SolicitudVisitaRequest $request)
	{
		try {

			$oficina =  Oficina::where('tipo_oficina_id', $request->tipo_oficina)->where('id', $request->id_oficina)->first() ??
						SalaJuntas::where('tipo_oficina_id', $request->tipo_oficina)->where('id', $request->id_oficina)->first() ??
						OficinaVirtual::where('tipo_oficina_id', $request->tipo_oficina)->where('id', $request->id_oficina)->first();

			if(is_null($oficina))
				throw new \Exception('El ID y tipo de oficina no corresponden con ningúno registrado');

			$solicitud =  $oficina->solicitudVisita()->create( $request->only(['nombre', 'email', 'telefono', 'comentario']) );
			if($solicitud == null)
				throw new \Exception('Error al insertar la solicitud');

			$notification = NotificationAdmin::create([
				'titulo' => 'Solicitud de visita',
				'descripción' => 'Han solicitado una visita a las oficinas',
				'data' => json_encode($solicitud->toArray()),
			]);

			event(new NotificationAdminSender($notification));
			event(new SolicitudVisitaCreated($solicitud));

			return response([
				'message' => 'Solicitud de visita registrada con éxito',
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al hacer el registro de contacto'
			], 501);
		}
	}

	public function destroy($id)
	{
		try {

			SolicitudVisita::findOrFail($id)->delete();

			return response([
				'message' => 'Solicitud de visita eliminado'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al eliminar la solicitud de visita'
			]);
		}
	}

	public function update($id)
	{
		try {

			SolicitudVisita::findOrFail($id)->update([
				'activo' => false,
			]);

			return response([
				'message' => 'Solicitud actualizada con éxito',
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al marcar como inactivo'
			], 501);
		}
	}

}
