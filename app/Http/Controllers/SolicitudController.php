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
use App\OficinaVirtual;
use App\SalaJuntas;
use App\PushNotificationSentToUser;
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

	public function getUserHistory(Request $request)
	{
		$data = $this->solicitudRepository->getUserHistory($request->user()->id);

		return response($data);
	}

	public function index(Request $request){
		try {
			// $edificioId = 1;

			$data = $this->solicitudRepository->getAll(); //$this->solicitudRepository->getAllByEdificioId($edificioId);

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

	public function finalizar($id)
	{
		try{

			DB::beginTransaction();

			$solicitud = SolicitudReservacion::with('user', 'solicitudable')->findOrFail($id);
			$solicitud->estado_id = 5;
			$solicitud->save();

			$solicitud->solicitudable->en_uso = false;
			$solicitud->solicitudable->save();

			$notification = PushNotificationSentToUser::create([
				'user_id' => $solicitud->user->id,
				'title' => "Solicitud {$solicitud->folio} finalizada",
				'body' => 'La renta de su oficina ha finalizado',
				'data'=> json_encode([
					'solicitud_id' => $solicitud->id,
					'type' => 'SOLICITUD_FINALIZADA',
				]),
			]);

			try {
				$expo = \ExponentPhpSDK\Expo::normalSetup();
				$expo->notify('', [
					'to' => $solicitud->user->push_notification_token,
					'title' => $notification->title,
					'body' => $notification->body,
					'data' => $notification->data ,
				]);
			} catch (\Throwable $th) {
				Log::error($th->getMessage());
			}

			DB::commit();

			return response([
				'message' => 'Solicitud actualizada con ??xito'
			]);
		}catch(\Throwable $th){
			DB::rollBack();

			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurri?? un error al finalizar la solicitud'
			], 500);
		}
	}

	public function autorizar($id){
		try {
			DB::beginTransaction();

			$solicitud = SolicitudReservacion::with('user', 'solicitudable')->findOrFail($id);
			$solicitud->estado_id = 2;
			$solicitud->save();

			$solicitud->solicitudable->en_uso = true;
			$solicitud->solicitudable->save();

			$notification = PushNotificationSentToUser::create([
				'user_id' => $solicitud->user->id,
				'title' => "Solicitud {$solicitud->folio} aprobada",
				'body' => "La renta de su oficina fue aprobada ????",
				'data' => json_encode([
					'solicitud_id' => $solicitud->id,
					'type' => 'SOLICITUD_APROBADA'
				]),
			]);

			try{
				$expo = \ExponentPhpSDK\Expo::normalSetup();
				$expo->notify('', [
					'to' => $solicitud->user->push_notification_token,
					'title' => $notification->title,
					'body' => $notification->body,
					'data' => $notification->data ,
				]);
			}catch(\Throwable $th){
				Log::error($th->getMessage());
			}

			DB::commit();

			return response([
				'message' => 'Solicitud autorizada con ??xito'
			]);
		} catch (\Throwable $th) {
			DB::rollBack();

			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurri?? un error al autorizar la solicitud'
			]);
		}
	}

	public function noAutorizar($id){
		try {

			$solicitud = SolicitudReservacion::findOrFail($id);
			$solicitud->estado_id = 3;
			$solicitud->save();

			return response([
				'message' => 'Solicitud no autorizada con ??xito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurri?? un error al no autorizar la solicitud'
			]);
		}
	}

	public function cancelar($id){
		try {
			$solicitud = SolicitudReservacion::findOrFail($id);
			$solicitud->estado_id = 4;
			$solicitud->save();

			return response([
				'message' => 'Solicitud cancelada con ??xito',
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([
				'error' => 'Ocurri?? un error al cancelar la solicitud'
			]);
		}
	}

	public function destroy($id){
		try {
			$solicitud = SolicitudReservacion::findOrFail($id);

			$solicitud->delete();

			return response([
				'message' => 'Solicitud borrada con ??xito',
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurri?? un error al eliminar la solicitud'
			], 500);
		}
	}

	private function getFolioKeyToTypeOficina(int $tipoOficina){
		switch ($tipoOficina) {
			case 1:
				return 'EUOP';
			case 2:
				return 'EUSJ';
			case 3:
				return 'EUOV';
			default:
				return null;
		}
	}

	public function getAdicionalesSolicitud($id)
	{
		try{
			$adicionales = SolicitudReservacion::with('adicionalesComprados', 'adicionalesComprados.adicionalesComprados', 'adicionalesComprados.adicionalesComprados.adicionales')->findOrFail($id);

			return response($adicionales->adicionalesComprados);
		}catch(\Throwable $th){
			Log::error($th->getMessage());

			return response([]);
		}
	}

	public function storeSolicitudOficina(\App\Http\Requests\SolicitudOficinaRequest $request){
		try {
			DB::beginTransaction();
			$tipoOficina = $request->tipo_oficina;
			$tipoFolio = $this->getFolioKeyToTypeOficina($tipoOficina);
			$folio = $this->foliosRepository->getCurrentFolio($tipoFolio);

			$oficina =  Oficina::where('tipo_oficina_id', $tipoOficina)->where('id', $request->id)->first() ??
						SalaJuntas::where('tipo_oficina_id', $tipoOficina)->where('id', $request->id)->first() ??
						OficinaVirtual::where('tipo_oficina_id', $tipoOficina)->where('id', $request->id)->first();

			if(is_null($oficina))
				throw new \Exception('El ID y tipo de oficina no corresponden con ning??no registrado');

			$solicitud = $oficina->solicitud()->create([
				'user_id' => $request->user()->id,
				'estado_id' => 1,
				'folio' => $folio,
				'tipo_oficina' => $tipoOficina,
				'fecha_reservacion' => Carbon::parse($request->fecha_reservacion),
				'meses_renta' => $tipoOficina == 3 ? 1 : $request->meses_renta,
				'numero_integrantes' => $tipoOficina == 3 ? 1 : $request->numero_integrantes,
				'hora_inicio' => $tipoOficina == 2 ? Carbon::parse($request->hora_inicio) : null,
				'hora_fin' => $tipoOficina == 2 ? Carbon::parse($request->hora_fin) : null,
				'metodo_pago_id' => null,
			]);

			$this->foliosRepository->generateNextFolio($tipoFolio);

			$message = NotificationSolicitudMessage::create([
				'user_id' => $request->user()->id,
				'edificio_id' => $oficina->edificio_id,
				'solicitud_id' => $solicitud->id,
				'type' => 1,
				'status_solicitud' => 1,
				'body' => 'Se cre?? una nueva solicitud de renta para una oficina fisica',
			]);

			$edificio = Edificio::findOrFail(1);

			$edificio->notify(new \App\Notifications\NotificationSolicitudCreated($message));

			DB::commit();

			return response([
				'message' => 'Solicitud generada con ??xito',
			]);
		} catch (\Throwable $th) {
			DB::rollBack();
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurri?? un error al registrar la solicitud'
			], 500);
		}
	}

}
