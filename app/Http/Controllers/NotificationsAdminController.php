<?php

namespace App\Http\Controllers;

use App\NotificationAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationsAdminController extends Controller
{

	public function destroyAll(){
		try {

			DB::table('notifications_admin')->delete();

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

	public function destroy($id){
		try {

			NotificationAdmin::findOrFail($id)->delete();

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

			$notifications = NotificationAdmin::orderBy('created_at', 'desc')->get();

			return response($notifications);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

}
