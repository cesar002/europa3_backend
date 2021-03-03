<?php

namespace App\Http\Controllers;

use App\Events\MessageChatSolicitudReceived;
use App\Repositories\ChatRecepcionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatRecepcionController extends Controller
{

	private $chatRepositoy;

	public function __construct(ChatRecepcionRepository $chatRepositoy){
		$this->chatRepositoy = $chatRepositoy;
	}

	public function getSolicitudesByUserId(Request $request){
		try {
			$userId = $request->user()->id;
			$data = $this->chatRepositoy->getSolicitudesByUserId($userId);

			return response($data);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

	public function getSolicitudesChat(Request $request){
		try {
			$idEdificio = $request->user('api-admin')->edificio_id;
			$data = $this->chatRepositoy->getSolicitudesChat($idEdificio);

			return response($data);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([]);
		}
	}

	public function receiveUserMessageChat(Request $request){
		try {

			$user = $request->user();

			$mensajeChat = $user->chatRecepcion()->create([
				'sender_by' => 2,
				'mensaje' => $request->mensaje['text'],
				'edificio_id' => $request->edificio_id,
				'solicitud_id' => $request->solicitud_id,
			]);

			$message = $this->chatRepositoy->getMessageById($mensajeChat->id);

			event(new MessageChatSolicitudReceived([
				'model' => $mensajeChat,
				'message' => $message
			]));

			return response($message);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([
				'error' => 'Ocurrió un error al recibir el mensaje'
			], 500);
		}
	}

	public function receiveEdificioMessageChat(Request $request){
		try {
			$user = $request->user('api-admin');

			$mensajeChat = $user->chatRecepcion()->create([
				'sender_by' => 1,
				'mensaje' => $request->mensaje,
				'edificio_id' => $request->edificio_id,
				'solicitud_id' => $request->solicitud_id,
			]);

			$message = $this->chatRepositoy->getMessageById($mensajeChat->id);

			event(new MessageChatSolicitudReceived([
				'model' => $mensajeChat,
				'message' => $message
			]));

			return response($message);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([
				'error' => 'Ocurrió un error al recibir el mensaje'
			], 500);
		}
	}

	public function getChatMessageSolicitud($id){
		try {
			$messages = $this->chatRepositoy->getMessagesBySolicitudId($id);

			return response($messages);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([]);
		}
	}

}
