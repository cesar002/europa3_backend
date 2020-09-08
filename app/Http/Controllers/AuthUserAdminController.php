<?php

namespace App\Http\Controllers;

use App\UserAdmin;
use App\UserAdminPermiso;
use App\UserAdminPersonalData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AuthUserAdminController extends Controller
{

	public function register(\App\Http\Requests\RegisterUserAdminRequest $request){
		try {
			DB::beginTransaction();

			$permisos = $request->permisos;

			$user = new UserAdmin([
				'username' => $request->username,
				'password' => bcrypt($request->password),
			]);

			$user->save();

			$userData = new UserAdminPersonalData();
			$userData->user_admin_id = $user->id;
			$userData->path_id = 1;
			$userData->nombre = $request->nombre;
			$userData->ap_p = $request->ape_pat;
			$userData->ap_m = $request->ape_mat;
			$userData->save();


			$paths = $userData->pathImage()->with('pathMaster')->first();

			if(!is_null($request->file('avatar_image'))){
				$image_saved = $request->file('avatar_image')->store("{$paths->pathMaster->path}/{$paths->path}");
				$userData->avatar_image = basename($image_saved);
				$userData->save();
			}

			foreach($permisos as $permiso){
				$userPermiso = new UserAdminPermiso();
				$userPermiso->user_admin_id = $user->id;
				$userPermiso->permiso_id = $permiso;
				$userPermiso->save();
			}

			DB::commit();

			return response([
				'message' => 'usuario creado con éxito'
			]);
		} catch (\Throwable $th) {
			DB::rollBack();

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
			Log::error($th->getMessage());

			return response([
				'error' => 'no se pudo iniciar sesión'
			], 500);
		}
	}

}
