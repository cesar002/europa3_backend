<?php

namespace App\Http\Controllers;

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
				'numero_integrantes' => 5 //$request->numero_integrantes,
			]);

			$oficina = Oficina::findOrFail($request->oficina_id);
			$edificio = $oficina->edificio()->first();
			$edificio->notify(new NotificationSolicitudCreated([
				'sender_by' => $request->user()->id,
				'recipient_by' => $edificio->id,
				'email' => $request->user()->email,
				'body' => "Se ha comenzado nueva solicitud de renta para la oficina - {$oficina->nombre}",
				'created_at' => Carbon::now(),
			]));

			$solicitudOficina->save();

			$this->foliosRepository->generateNextFolio('EUOP');

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
