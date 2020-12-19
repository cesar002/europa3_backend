<?php

namespace App\Repositories;

use App\Interfaces\ISolicitudOficinaDao;
use App\Oficina;
use App\SalaJuntas;
use App\SolicitudReservacion;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SolicitudOficinaRepository implements ISolicitudOficinaDao{

	public function getAll(){
		try {

		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getByUserId($userId){
		try {
			$solicitudes = SolicitudReservacion::with(
				'documentos', 'documentos.estado','documentos.tipoDocumento', 'estado', 'solicitudable',
				'metodoPago', 'tipoOficina', 'solicitudable.edificio' ,'solicitudable.imagenes', 'solicitudable.pathImages',
				'solicitudable.pathImages.pathMaster', 'fechasPago', 'fechasPago.pago',
				)->where('user_id', $userId)->get();

			$solicitudesJson = $solicitudes->map(function($solicitud){
				$path = "{$solicitud->solicitudable->pathImages->pathMaster->path}/{$solicitud->solicitudable->pathImages->path}";
				$image = $solicitud->solicitudable->imagenes[0];
				$pathImage = "{$path}/{$image->image}";

				return [
					'id' => $solicitud->id,
					'folio' => $solicitud->folio,
					'solicitud_id' => $solicitud->solicitud_id,
					'estado' => $solicitud->estado,
					'metodo_pago' => $solicitud->metodoPago,
					'fecha_reservacion' => $solicitud->fecha_reservacion,
					'meses_renta' => $solicitud->meses_renta,
					'numero_integrantes' => $solicitud->numero_integrantes,
					'documentos' => $solicitud->documentos,
					'tipo_oficina' => $solicitud->tipoOficina,
					'fechas_pago' => $solicitud->fechasPago,
					'numero_integrantes' => $solicitud->numero_integrantes,
					'hora_inicio' => $solicitud->hora_inicio,
					'hora_fin' => $solicitud->hora_fin,
					'body' => [
						'id' => $solicitud->solicitudable->id,
						'nombre' => $solicitud->solicitudable->nombre,
						'size_dimension' => $solicitud->solicitudable->size_dimension,
						'capacidad_recomendada' => $solicitud->solicitudable->capacidad_recomendada,
						'capacidad_maxima' => $solicitud->solicitudable->capacidad_maxima,
						'edificio' => $solicitud->solicitudable->edificio,
						'tipoOficina' => $solicitud->solicitudable->tipoOficina,
						'precio' => $solicitud->solicitudable->precio,
						'image' => asset(Storage::url($pathImage)),
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

			// $data = SolicitudReservacion::with(
			// 	'tipoOficina','estado', 'solicitudable',
			// 	'user', 'user.infoPersonal'
			// )
			// ->whereHas('solicitudable', function($query) use($edificioId){
				// $query->whereHas('oficina', function($query) use($edificioId){
			// 		$query->where('edificio_id', $edificioId);
				// });
			// })
			// ->orWhereHas('solicitudSalaJunta', function($query) use($edificioId){
			// 	$query->whereHas('salaJuntas', function($query) use($edificioId){
			// 		$query->where('edificio_id', $edificioId);
			// 	});
			// })
			// ->get();

			$data = SolicitudReservacion::with(
				'tipoOficina','estado', 'solicitudable',
				'user', 'user.infoPersonal'
			)->whereHasMorph('solicitudable', [Oficina::class, SalaJuntas::class], function($query) use($edificioId){
				$query->where('edificio_id', $edificioId);
			})
			->get();

			return $data;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

	public function getToUserBySolicitudId($id){
		try {
			$solicitud = SolicitudReservacion::with('user', 'user.infoPersonal', 'user.infoPersonal.tipoIdentificacion','user.datosMorales', 'user.datosFiscales',
													'solicitudable', 'solicitudable.edificio', 'solicitudable.tipoOficina',
													'tipoOficina','estado',
													'metodoPago','documentos', 'documentos.estado', 'documentos.tipoDocumento')
						->findOrFail($id);
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
				'metodo_pago' => $solicitud->metodoPago,
				'body' => [
					'id' => $solicitud->solicitudable->id,
					'nombre' => $solicitud->solicitudable->nombre,
					'edificio' => [
						'id' => $solicitud->solicitudable->edificio->id,
						'nombre' => $solicitud->solicitudable->edificio->nombre,

					],
				],
				'documentos' => $solicitud->documentos,
				'insumos' => [

				],
				'meses_renta' => $solicitud->solicitudable->meses_renta,
				'numero_integrantes' => $solicitud->solicitudable->numero_integrantes,
				'fecha_a_reservar' => $solicitud->solicitudable->fecha_reservacion,
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
				'estado', 'solicitudable', 'solicitudable.edificio',
				'metodoPago', 'documentos', 'documentos.estado', 'documentos.tipoDocumento', 'fechasPago', 'fechasPago.pago',
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

