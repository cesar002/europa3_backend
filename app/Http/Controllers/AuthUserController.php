<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthUserController extends Controller
{

	public function register(\App\Http\Requests\RegisterUserRequest $request){
		try {

			$user = new User([
				'email' => $request->email,
				'password' => bcrypt($request->password)
			]);

			$user->save();

			return response([
				'message' => 'usuario registrado con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'No se logró registrar al usuario'
			], 500);
		}
	}

	public function login(\App\Http\Requests\LoginUserRequest $request){
		try {

			if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
				return response(['error' => 'Datos de sesión incorrectos'], 401);

			$SECRET_KEY = DB::select('SELECT id, secret FROM oauth_clients WHERE id = 2 LIMIT 1');

			$url = env('APP_URL', 'http://europa3_backend.oo');
			$http = new \GuzzleHttp\Client();
			$response = $http->post("$url/oauth/token", [
				'form_params' => [
					'grant_type' => 'password',
					'client_id' => $SECRET_KEY[0]->id,
					'client_secret' => $SECRET_KEY[0]->secret,
					'username' => $request->email,
					'password' => $request->password,
					'scopre' => '',
				]
			]);

			return response([
				'access_token' => json_decode((string) $response->getBody(), true)
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al intentar hacer el login'
			], 500);
		}
	}

	public function logout(Request $request){
		try {
			$request->user()->token()->revoke();

			return response([
				'message' => 'Se cerró sesión con éxito',
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([
				'error' => 'Ocurrió un error al intentar cerrar sesión'
			], 500);
		}
	}

}
