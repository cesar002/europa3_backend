<?php

namespace App\Repositories;

use App\AdicionalCompraSolicitud;
use App\Interfaces\IAdicionalesCompradosDao;
use Illuminate\Support\Facades\Log;

class AdicionalesCompradosRepository implements IAdicionalesCompradosDao {

	public function getAll(){
		try {
			$adicionales = AdicionalCompraSolicitud::with(
							'solicitud', 'solicitud.user', 'adicionalesComprados', 'adicionalesComprados.adicionales'
							)->get();

			return $adicionales;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

	public function getById($id){
		try {
			$adicional = AdicionalCompraSolicitud::with(
							'solicitud', 'solicitud.user', 'adicionalesComprados', 'adicionalesComprados.adicionales'
						)->findOrFail($id);

			return $adicional;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

	public function getByUserId($userId){
		try {
			$adicionales = AdicionalCompraSolicitud::with(
							'solicitud', 'solicitud.user', 'adicionalesComprados', 'adicionalesComprados.adicionales'
						)->whereHas('solicitud', function($query) use($userId){
							$query->where('user_id', $userId);
						})->get();

			return $adicionales;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

	public function getBySolicitudId($solicitudId){
		try {
			$adicionales = AdicionalCompraSolicitud::with(
							'solicitud', 'solicitud.user', 'adicionalesComprados', 'adicionalesComprados.adicionales'
						)->where('solicitud_id', $solicitudId);

			return $adicionales;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

}
