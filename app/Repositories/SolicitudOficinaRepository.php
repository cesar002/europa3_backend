<?php

namespace App\Repositories;

use App\Interfaces\ISolicitudOficinaDao;
use App\SolicitudReservacion;
use Illuminate\Support\Facades\Log;

class SolicitudOficinaRepository implements ISolicitudOficinaDao{

	public function getAll(){
		try {
			//code...
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getById($id){
		try {
			$solicitud = SolicitudReservacion::with('user', 'user.infoPersonal', 'user.infoPersonal.tipoIdentificacion','user.datosMorales', 'user.datosFiscales',
													'solicitudOficina', 'solicitudOficina.oficina',
													'solicitudOficina.oficina.edificio', 'solicitudOficina.oficina.tipoOficina',
													'solicitudOficina.metodoPago','documentos', 'documentos.tipoDocumento')->findOrFail($id);
			return [
				'id' => $solicitud->id,
				'folio' => $solicitud->folio,
				'usuario' => [
					'id' => $solicitud->user->id,
					'email' => $solicitud->user->email,
					'datos_personales' => $solicitud->user->infoPersonal ?? [],
					'datos_morales' => $solicitud->user->datosMorales ?? [],
					'datos_fiscales' => $solicitud->user->datosFiscales ?? [],
				],
				'metodo_pago' => !is_null($solicitud->solicitudOficina->metodoPago) ? [] : null,
				'oficina' => [
					'id' => $solicitud->solicitudOficina->oficina->id,
					'nombre' => $solicitud->solicitudOficina->oficina->nombre,
					'edificio' => [
						'id' => $solicitud->solicitudOficina->oficina->edificio->id,
						'nombre' => $solicitud->solicitudOficina->oficina->edificio->nombre,

					],
				],
				'documentos' => $solicitud->documentos->map(function($documento){
					return [
						'id' => $documento->id,
						'tipo' => [
							'id' => $documento->tipoDocumento->id,
							'nombre' => $documento->tipoDocumento->documento,
							'validado' => $documento->validado,
						],
					];
				}),
				'insumos' => [

				],
				'meses_renta' => $solicitud->solicitudOficina->meses_renta,
				'numero_integrantes' => $solicitud->solicitudOficina->numero_integrantes,
				'fecha_a_reservar' => $solicitud->solicitudOficina->fecha_reservacion,
				'status' => [
					'iniciado' => $solicitud->iniciado,
					'documentos_subidos' => $solicitud->subida_documentos,
					'autorizado' => $solicitud->autorizado,
					'finalizado' => $solicitud->finalizado,
				],
				'fecha_solicitud' => $solicitud->created_at->format('Y-m-d'),
			];
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

	public function getByUserId($userId){
		try {
			//code...
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getByOficinaId($oficinaId){
		try {
			//code...
		} catch (\Throwable $th) {
			return [];
		}
	}

}

