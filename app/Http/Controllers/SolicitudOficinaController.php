<?php

namespace App\Http\Controllers;

use App\Events\SolicitudCreated;
use App\NotificacionSolicitudEdificio;
use App\Notifications\NotificationSolicitudCreated;
use App\Oficina;
use Illuminate\Http\Request;
use App\Repositories\SolicitudOficinaRepository;
use App\Repositories\FoliosRepository;
use App\SolicitudOficina;
use App\SolicitudReservacion;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SolicitudOficinaController extends Controller
{

	private $solicitudOficinaRepository;
	private $foliosRepository;

	public function __construct(SolicitudOficinaRepository $solicitudOficinaRepository, FoliosRepository $foliosRepository){
		$this->solicitudOficinaRepository = $solicitudOficinaRepository;
		$this->foliosRepository = $foliosRepository;
	}

	public function index(){

	}

	public function show($id){
		$data = $this->solicitudOficinaRepository->getById($id);

		return response($data);
	}

	public function store(\App\Http\Requests\SolicitudOficinaRequest $request){
		try {
			DB::beginTransaction();

			$folio = $this->foliosRepository->getCurrentFolio('EUOP');

			$solicitud = new SolicitudReservacion([
				'folio' => $folio,
				'user_id' => $request->user()->id,
			]);

			$solicitud->save();

			$solicitudOficina = new SolicitudOficina([
				'solicitud_id' => $solicitud->id,
				'oficina_id' => $request->oficina_id,
				'fecha_reservacion' => $request->fecha_reservacion,
				'meses_renta' => $request->meses_renta,
				'numero_integrantes' => 5,
			]);

			$edificio = Oficina::with('edificio')->findOrFail($request->oficina_id);
			$message = NotificacionSolicitudEdificio::create([
				'user_id' => $request->user()->id,
				'edificio_id' => $edificio->edificio->id,
				'solicitud_id' => $solicitud->id,
				'body' => 'Nueva solicitud para renta de oficina privada iniciada',
				'type' => 1,
			]);

			$solicitudOficina->save();

			$this->foliosRepository->generateNextFolio('EUOP');

			event(new SolicitudCreated($message));

			DB::commit();

			return response([
				'message' => 'Solicitud generada con éxito',
			]);
		} catch (\Throwable $th) {
			DB::rollBack();
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al registrar la solicitud'
			], 500);
		}
	}

	public function destroy($id){
		try {
			$solicitud = SolicitudReservacion::findOrFail($id);

			$solicitud->delete();

			return response([
				'message' => 'Solicitud borrada con éxito',
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al eliminar la solicitud'
			], 500);
		}
	}
}
