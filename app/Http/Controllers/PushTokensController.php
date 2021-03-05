<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PushTokensController extends Controller
{
    public function register(Request $request)
	{
		try {

			$user = $request->user();
			$user->push_notification_token = $request->push_token;
			$user->save();

			return response([
				'message' => 'Token actualizado con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al registrar el push token'
			], 501);
		}
	}

}
