<?php

namespace App\Repositories;

use App\Interfaces\ISolicitudOficinaDao;
use App\SolicitudReservacion;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SolicitudOficinaRepository implements ISolicitudOficinaDao{

	public function getAll(){
		try {
			//code...
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getByUserId($userId){
		try {
			$solicitudes = SolicitudReservacion::with(
				'documentos', 'documentos.estado','documentos.tipoDocumento', 'estado', 'solicitudOficina', 'solicitudOficina.oficina', 'solicitudOficina.oficina.tipoOficina',
				'solicitudOficina.oficina.edificio' ,'solicitudOficina.oficina.imagenes', 'solicitudOficina.oficina.pathImages',
				'solicitudOficina.oficina.pathImages.pathMaster', 'solicitudOficina.oficina.tipoOficina',
				'solicitudSalaJunta', 'solicitudSalaJunta.salaJuntas', 'solicitudSalaJunta.salaJuntas.tipoOficina',
				)->where('user_id', $userId)->get();

			$solicitudesJson = $solicitudes->map(function($solicitud){
				$path = "{$solicitud->solicitudOficina->oficina->pathImages->pathMaster->path}/{$solicitud->solicitudOficina->oficina->pathImages->path}";
				$image = $solicitud->solicitudOficina->oficina->imagenes[0];
				$pathImage = "{$path}/{$image->image}";

				return [
					'id' => $solicitud->id,
					'folio' => $solicitud->folio,
					'solicitud_id' => $solicitud->solicitud_id,
					'estado' => $solicitud->estado,
					'documentos' => $solicitud->documentos,
					'solicitudOficina' => [
						'id' => $solicitud->solicitudOficina->id,
						'metodo_pago' => null,
						'fecha_reservacion' => $solicitud->solicitudOficina->fecha_reservacion,
						'meses_renta' => $solicitud->solicitudOficina->meses_renta,
						'numero_integrantes' => $solicitud->solicitudOficina->numero_integrantes,
						'oficina' => [
							'id' => $solicitud->solicitudOficina->oficina->id,
							'nombre' => $solicitud->solicitudOficina->oficina->nombre,
							'size_dimension' => $solicitud->solicitudOficina->oficina->size_dimension,
							'capacidad_recomendada' => $solicitud->solicitudOficina->oficina->capacidad_recomendada,
							'capacidad_maxima' => $solicitud->solicitudOficina->capacidad_maxima,
							'precio' => $solicitud->solicitudOficina->oficina->precio,
							'edificio' => $solicitud->solicitudOficina->oficina->edificio,
							'tipoOficina' => $solicitud->solicitudOficina->oficina->tipoOficina,
							'image' => asset(Storage::url($pathImage)),
						],
					],
				];
			});

			return $solicitudesJson;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}


	public function getAllByEdificioId($edificioId){
		try {

			$data = SolicitudReservacion::with(
				'estado', 'solicitudOficina', 'solicitudOficina.oficina', 'solicitudOficina.oficina.tipoOficina',
				'solicitudSalaJunta', 'solicitudSalaJunta.salaJuntas', 'solicitudSalaJunta.salaJuntas.tipoOficina',
				'user', 'user.infoPersonal'
			)
			->orWhereHas('solicitudOficina', function($query) use($edificioId){
				$query->whereHas('oficina', function($query) use($edificioId){
					$query->where('edificio_id', $edificioId);
				});
			})
			->orWhereHas('solicitudSalaJunta', function($query) use($edificioId){
				$query->whereHas('salaJuntas', function($query) use($edificioId){
					$query->where('edificio_id', $edificioId);
				});
			})
			->get();

			return $data;
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getToUserBySolicitudId($id){
		try {
			$solicitud = SolicitudReservacion::with('user', 'user.infoPersonal', 'user.infoPersonal.tipoIdentificacion','user.datosMorales', 'user.datosFiscales',
													'solicitudOficina', 'solicitudOficina.oficina',
													'solicitudOficina.oficina.edificio', 'solicitudOficina.oficina.tipoOficina',
													'solicitudOficina.metodoPago','documentos', 'documentos.estado', 'documentos.tipoDocumento')->findOrFail($id);
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
				'documentos' => $solicitud->documentos,
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

	public function getById($id){
		try {

			$solicitud = SolicitudReservacion::with(
				'estado', 'solicitudOficina', 'solicitudOficina.oficina', 'solicitudOficina.oficina.edificio',
				'solicitudOficina.metodoPago', 'documentos', 'documentos.estado', 'documentos.tipoDocumento', 'fechasPago', 'fechasPago.pago',
				'solicitudSalaJunta', 'solicitudSalaJunta.salaJuntas',
				'user', 'user.infoPersonal','user.infoPersonal.tipoIdentificacion' ,'user.infoPersonal.nacionalidad',
				'user.datosMorales', 'user.datosFiscales', 'user.datosFiscales.estado', 'user.datosFiscales.municipio')
			->findOrFail($id);

			return $solicitud;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

	public function getSolicitudRawById($id){
		try {
			$solicitud = SolicitudReservacion::findOrFail($id);

			return $solicitud;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

}

