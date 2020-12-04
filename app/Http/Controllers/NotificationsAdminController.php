<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationsAdminController extends Controller
{

	public function destroyAll(Request $request){
		try {
			$edificioModel = \App\Edificio::findOrFail(1);

			$edificioModel->unreadNotifications->markAsRead();

			return response([
				'status' => 'Notificaciones marcadas como leídas'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([
				'error' => 'No se puedieron marcar las notificaciones como leidas'
			], 500);
		}
	}

	public function destroy(Request $request, $id){
		try {
			$edificioModel = \App\Edificio::findOrFail(1);

			$edificioModel->unreadNotifications->where('id', $id)->markAsRead();

			return response([
				'status' => 'Notificacion eliminada con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([
				'error' => 'No se pudo marcar la notificación'
			], 500);
		}
	}

	public function getNotifications(Request $request){
		try {
			$edificioModel = \App\Edificio::findOrFail(1);

			$notificationsRaw = $edificioModel->notifications->all();

			$notifications = collect($notificationsRaw)->map(function($not){
				return[
					'id' => $not->id,
					'type' => $not->type,
					'created_at' => $not->created_at,
					'updated_at' => $not->updated_at,
					'read_at' => $not->read_at,
					'data' => $not->data
				];
			});

			return response($notifications);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

}
