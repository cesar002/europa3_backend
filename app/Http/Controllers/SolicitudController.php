<?php

namespace App\Http\Controllers;

use App\DocumentoSolicitud;
use App\Repositories\SolicitudOficinaRepository;
use App\SolicitudReservacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\FoliosRepository;
use Illuminate\Support\Facades\DB;
use App\Edificio;
use App\NotificationSolicitudMessage;
use App\Oficina;
use App\SalaJuntas;
use Carbon\Carbon;

class SolicitudController extends Controller{

	private $solicitudRepository;
	private $foliosRepository;

	public function __construct(
		SolicitudOficinaRepository $solicitudRepository,
		FoliosRepository $foliosRepository
	){
		$this->solicitudRepository = $solicitudRepository;
		$this->foliosRepository = $foliosRepository;
	}

	public function getDocuments($id){
		try {
			$solicitud = DocumentoSolicitud::with('tipoDocumento', 'estado')->where('solicitud_id', $id)->get();

			return response($solicitud);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([]);
		}
	}

	public function getToUser(Request $request){
		try {

			$data = $this->solicitudRepository->getByUserId($request->user()->id);

			return response($data);

		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([]);
		}
	}

	public function index(Request $request){
		try {
			$edificioId = 1;

			$data = $this->solicitudRepository->getAllByEdificioId($edificioId);

			return response($data);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([]);
		}
	}

	public function show($id){
		try {

			$solicitud =  $this->solicitudRepository->getById($id);

			return response($solicitud);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response(json_encode([], JSON_FORCE_OBJECT));
		}
	}

	public function showAdmin($id){
		try {

			$solicitud =  $this->solicitudRepository->getByIdAdmin($id);

			return response($solicitud);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response(json_encode([], JSON_FORCE_OBJECT));
		}
	}

	public function autorizar($id){
		try {

			$solicitud = SolicitudReservacion::findOrFail($id);
			$solicitud->estado_id = 2;
			$solicitud->save();

			return response([
				'message' => 'Solicitud autorizada con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al autorizar la solicitud'
			]);
		}
	}

	public function noAutorizar($id){
		try {

			$solicitud = SolicitudReservacion::findOrFail($id);
			$solicitud->estado_id = 3;
			$solicitud->save();

			return response([
				'message' => 'Solicitud no autorizada con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al no autorizar la solicitud'
			]);
		}
	}

	public function cancelar($id){
		try {
			$solicitud = SolicitudReservacion::findOrFail($id);
			$solicitud->estado_id = 4;
			$solicitud->save();

			return response([
				'message' => 'Solicitud cancelada con éxito',
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([
				'error' => 'Ocurrió un error al cancelar la solicitud'
			]);
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

	public function storeSolicitudOficina(\App\Http\Requests\SolicitudOficinaRequest $request){
		try {
			DB::beginTransaction();
			$tipoOficina = $request->tipo_oficina;
			$folio = '';

			if($tipoOficina == 1){
				$folio = $this->foliosRepository->getCurrentFolio('EUOP');

				$oficina = Oficina::findOrFail($request->id);
				$solicitud = $oficina->solicitud()->create([
					'user_id' => $request->user()->id,
					'estado_id' => 1,
					'folio' => $folio,
					'tipo_oficina' => $tipoOficina,
					'fecha_reservacion' => Carbon::parse($request->fecha_reservacion),
					'meses_renta' => $request->meses_renta,
					'numero_integrantes' => 5, //$request->numero_integrantes,
					'metodo_pago_id' => null,
				]);

				$this->foliosRepository->generateNextFolio('EUOP');
			}else{
				$folio = $this->foliosRepository->getCurrentFolio('EUSJ');

				$sala = SalaJuntas::findOrFail($request->id);
				$solicitud = $sala->solicitud()->create([
					'user_id' => $request->user()->id,
					'estado_id' => 1,
					'folio' => $folio,
					'tipo_oficina' => $tipoOficina,
					'fecha_reservacion' => Carbon::parse($request->fecha_reservacion),
					'meses_renta' => 1,
					'hora_inicio' => Carbon::parse($request->hora_inicio), //$request->hora_inicio,
					'hora_fin' => Carbon::parse($request->hora_fin),
					'numero_integrantes' => 5, //$request->numero_integrantes,
					'metodo_pago_id' => null,
				]);

				$this->foliosRepository->generateNextFolio('EUSJ');
			}

			// $message = NotificationSolicitudMessage::create([
			// 	'user_id' => $request->user()->id,
			// 	'edificio_id' => $oficina->edificio_id,
			// 	'solicitud_id' => $solicitud->id,
			// 	'type' => 1,
			// 	'status_solicitud' => 1,
			// 	'body' => 'Se creó una nueva solicitud de renta para una oficina fisica',
			// ]);

			// $edificio = Edificio::findOrFail($oficina->edificio_id);

			// $edificio->notify(new \App\Notifications\NotificationSolicitudCreated($message));

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

}
