<?php

namespace App\Http\Controllers;

use App\UserAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthUserAdminController extends Controller
{

	public function register(\App\Http\Requests\RegisterUserAdminRequest $request){
		try {

			$user = new UserAdmin([
				'username' => $request->username,
				'password' => bcrypt($request->password),
			]);

			$user->save();

			return response([
				'message' => 'usuario creado con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th);

			return response([
				'error' => 'No se logró registrar al usuario',
			], 500);
		}
	}

	public function login(\App\Http\Requests\LoginUserAdminRequest $request){
		try {

			if(!Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password]))
				return response(['error' => 'Datos de sesión incorrectos'], 401);

			$SECRET_KEY = DB::select('SELECT id, secret FROM oauth_clients WHERE id = 3 LIMIT 1');

			$url = env('APP_URL', 'http://europa3_backend.oo');
			$http = new \GuzzleHttp\Client();
			$response = $http->post("$url/oauth/token", [
				'form_params' => [
					'grant_type' => 'password',
					'client_id' => $SECRET_KEY[0]->id,
					'client_secret' => $SECRET_KEY[0]->secret,
					'username' => $request->username,
					'password' => $request->password,
					'scopre' => '',
				]
			]);

			return response([
				'access_token' => json_decode((string) $response->getBody(), true)
			]);
		} catch (\Throwable $th) {
			//throw $th;
		}
	}

}
