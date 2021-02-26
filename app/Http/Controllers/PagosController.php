<?php

namespace App\Http\Controllers;

use App\Adicional;
use App\FechaPago;
use Carbon\Carbon;
use App\RegistroPago;
use App\AdicionalComprado;
use Illuminate\Http\Request;
use App\SolicitudReservacion;
use App\AdicionalCompraSolicitud;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\SolicitudPayRequest;

class PagosController extends Controller
{

	public function payConfirmationSolicitud(SolicitudPayRequest $request, $id){
		try {

			$solicitud = SolicitudReservacion::with('solicitudable')->findOrFail($id);

			DB::beginTransaction();

			$first = true;
			$currentDay = Carbon::now();
			for ($i=0; $i < $solicitud->meses_renta; $i++) {
				$aux = $currentDay;
				FechaPago::create([
					'solicitud_id' => $solicitud->id,
					'fecha_pago' => $aux,
					'monto_pago' => $first ? $request->montoTotal : $solicitud->solicitudable->precio,
				]);

				$currentDay = $aux->addMonthNoOverflow();
				$first =  false;
			}

			if(!empty($request->adicionales)){
				$adicionalesComprados = AdicionalCompraSolicitud::create([
					'solicitud_id' => $solicitud->id,
					'folio_pago' => 'XXXXXXX',
				]);


				foreach($request->adicionales as $index => $value){
					$adicionalModel = Adicional::findOrFail($value['adicional_id']);
					AdicionalComprado::create([
						'compra_id' => $adicionalesComprados->id,
						'adicional_id' => $value['adicional_id'],
						'cantidad' => ($value['cantidad'] * $adicionalModel->unidad_base),
					]);
				}
			}

			$fecha = FechaPago::where('solicitud_id', $solicitud->id)->first();
			RegistroPago::create([
				'user_id' => $request->user()->id,
				'fecha_id' => $fecha->id,
				'referencia' => 'XXXXXXXX',
				'fecha_pago' => Carbon::now(),
				'verificado' => true,
			]);

			$solicitud->estado_id = 7;
			$solicitud->save();

			DB::commit();

			return response([
				'message' => 'Pago registrado con éxito'
			]);
		} catch (\Throwable $th) {
			DB::rollBack();

			Log::error($th->getMessage());
			return response([
				'error' => 'Ocurrió un error al registrar el pago'
			], 500);
		}
	}

	public function payMesSolicitud(Request $request, $id, $idFecha){
		try {
			$fecha = FechaPago::where('id', $idFecha)->where('solicitud_id', $id)->firstOrFail();

			RegistroPago::create([
				'user_id' => $request->user()->id,
				'fecha_id' => $fecha->id,
				'referencia' => 'XXXXXX',
				'fecha_pago' => Carbon::now(),
				'verificado' => true,
			]);

			return response([
				'message' => 'Pago realizado con éxito',
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al realizar el registro del pago'
			], 500);
		}
	}

	public function payAdicionales(Request $request, $id){
		try {
			$solicitud = SolicitudReservacion::findOrFail($id);

			DB::beginTransaction();

			$compraSolicitud = AdicionalCompraSolicitud::create([
				'solicitud_id' => $solicitud->id,
				'folio_pago' => 'XXXXXXX'
			]);

			foreach($request->adicionales as $index => $adicional){
				$adicionalM = Adicional::findOrFail($adicional['adicional_id']);
				AdicionalComprado::create([
					'compra_id' => $compraSolicitud->id,
					'adicional_id' => $adicionalM->id,
					'cantidad' => ($adicionalM->unidad_base * $adicional['cantidad']),
				]);
			}

			DB::commit();

			return response([
				'message' => 'Registro de pago éxitoso'
			]);
		} catch (\Throwable $th) {
			DB::rollBack();
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un erro al realizar el registro del pago'
			], 500);
		}
	}

}
