<?php

namespace App\Http\Controllers;

use App\FechaPago;
use App\Oficina;
use App\SolicitudReservacion;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SolicitudesRentaController extends Controller{

	private $solicitudRepository;

	public function __construct(\App\Repositories\SolicitudRentaRepository $solicitudRentaRepository){
		$this->solicitudRepository = $solicitudRentaRepository;
	}

	public function index(){
		$solicitudes = $this->solicitudRepository->getAll();

		return response($solicitudes);
	}

	public function show($id){
		$solicitud = $this->solicitudRepository->getById($id);

		return response($solicitud);
	}

	public function store(\App\Http\Requests\SolicitudRentaRequest $request){
		try {
			DB::beginTransaction();

			$mesesRenta = $request->meses_renta;
			$folio = '';

			$oficina = Oficina::findOrFail($request->oficina_id);

			$solicitud = new SolicitudReservacion([
				'folio' => $folio,
				'user_id' => $request->user()->id,
				'oficina_id' => $request->oficina_id,
				'metodo_pago_id' => $request->metodo_pago_id,
				'plazo' => $request->meses_renta,
				'numero_ocupantes' => $request->numero_ocupantes,
				'terminos_condiciones' => true,
			]);

			$solicitud->save();

			$currentFecha = Carbon::now();

			for ($i=0; $i < $mesesRenta; $i++) {
				$fechaPago = new FechaPago();

				$fechaPago->solicitud_id = $solicitud->id;
				$fechaPago->fecha_pago = $currentFecha;
				$fechaPago->monto_pago = $oficina->precio;

				$fechaPago->save();

				$currentFecha = $currentFecha->addMonth();
			}

			DB::commit();

			return response([
				'message' => 'Solicitud de renta registrada con éxito'
			], 201);
		} catch (\Throwable $th) {
			DB::rollBack();

			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al registrar la solicitud'
			], 500);
		}
	}
}
