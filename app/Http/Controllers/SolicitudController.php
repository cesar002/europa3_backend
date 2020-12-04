<?php

namespace App\Http\Controllers;

use App\DocumentoSolicitud;
use App\Repositories\SolicitudOficinaRepository;
use App\SolicitudReservacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Storage;

class SolicitudController extends Controller{

	private $solicitudRepository;

	public function __construct(SolicitudOficinaRepository $solicitudRepository){
		$this->solicitudRepository = $solicitudRepository;
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
			$userId = $request->user()->id;

			$data = $this->solicitudRepository->getByUserId($userId);

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

}
