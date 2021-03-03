<?php

namespace App\Repositories;

use App\Oficina;
use App\SalaJuntas;
use App\ChatRecepcion;
use App\SolicitudReservacion;
use Illuminate\Support\Facades\Log;
use App\Interfaces\IChatRecepcionDao;
use Illuminate\Support\Facades\Storage;

class ChatRecepcionRepository implements IChatRecepcionDao{

	public function getSolicitudesByUserId($userId){
		try {
			$solicitudes = SolicitudReservacion::with(
				'solicitudable','solicitudable.imagenes', 'solicitudable.pathImages',
				'solicitudable.pathImages.pathMaster', 'solicitudable.edificio'
			)->where('user_id', $userId)->where(function($query){
				$query->where('estado_id', 2)->orWhere('estado_id', 6);
			})
			->get();

			$data = $solicitudes->map(function($solicitud){
				$path = "{$solicitud->solicitudable->pathImages->pathMaster->path}/{$solicitud->solicitudable->pathImages->path}";
				$image = $solicitud->solicitudable->imagenes[0];
				$pathImage = "{$path}/{$image->image}";

				return [
					'id' => $solicitud->id,
					'folio' => $solicitud->folio,
					'body' => [
						'nombre' => $solicitud->solicitudable->nombre,
						'img' => asset(Storage::url($pathImage)),
						'edificio' => [
							'id' => $solicitud->solicitudable->edificio->id,
							'nombre' => $solicitud->solicitudable->edificio->nombre,
						]
					],
					'chats' => $this->getMessagesBySolicitudId($solicitud->id),
				];
			});

			return $data;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return [];
		}
	}

	public function getSolicitudesChat($edificioId){
		try {
			$solicitudes = SolicitudReservacion::with(
				'solicitudable', 'solicitudable.imagenes', 'solicitudable.pathImages',
				'solicitudable.pathImages.pathMaster', 'solicitudable.edificio',
				'user', 'user.infoPersonal'
			)->whereHasMorph('solicitudable', [Oficina::class, SalaJuntas::class], function($query) use($edificioId){
				$query->where('edificio_id', $edificioId);
			})->where('estado_id', 2)->orWhere('estado_id', 6)
			->get();


			$data = $solicitudes->map(function($solicitud) {
				$path = "{$solicitud->solicitudable->pathImages->pathMaster->path}/{$solicitud->solicitudable->pathImages->path}";
				$image = $solicitud->solicitudable->imagenes[0];
				$pathImage = "{$path}/{$image->image}";

				return [
					'id' => $solicitud->id,
					'folio' => $solicitud->folio,
					'user' => $solicitud->user,
					'body' => [
						'nombre' => $solicitud->solicitudable->nombre,
						'img' => asset(Storage::url($pathImage)),
						'edificio' => [
							'id' => $solicitud->solicitudable->edificio->id,
							'nombre' => $solicitud->solicitudable->edificio->nombre,
						]
					],
					'chats' => $this->getMessagesBySolicitudId($solicitud->id),
				];
			});

			return $data;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

	public function getMessageById($id){
		try {
			$message = ChatRecepcion::with('chatable')->findOrFail($id);

			return [
				'sender_by' => $message->sender_by,
				'solicitud_id' => $message->solicitud_id,
				'_id' => $message->id,
				'text' => $message->mensaje,
				'createdAt' => $message->created_at,
				'user' => [
					'_id' => $message->chatable->id,
					'name' => $message->chatable->username ?? $message->chatable->email
				],
			];
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

	public function getMessagesBySolicitudId($id){
		try {
			$messages = ChatRecepcion::with('chatable')->where('solicitud_id', $id)->orderBy('created_at', 'desc')->get();

			return $messages->map(function($message){
				return [
					'sender_by' => $message->sender_by,
					'solicitud_id' => $message->solicitud_id,
					'_id' => $message->id,
					'text' => $message->mensaje,
					'createdAt' => $message->created_at,
					'user' => [
						'_id' => $message->chatable->id,
						'name' => $message->chatable->username ?? $message->chatable->email
					],
				];
			});
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

}
