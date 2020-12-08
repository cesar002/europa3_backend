<?php

namespace App\Repositories;

use App\ChatRecepcion;
use App\Interfaces\IChatRecepcionDao;
use Illuminate\Support\Facades\Log;

class ChatRecepcionRepository implements IChatRecepcionDao{

	public function getMessageById($id){
		try {
			$message = ChatRecepcion::with('chatable')->findOrFail($id);

			return [
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
			$messages = ChatRecepcion::with('chatable')->where('solicitud_id', $id)->get();

			return $messages->map(function($message){
				return [
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
