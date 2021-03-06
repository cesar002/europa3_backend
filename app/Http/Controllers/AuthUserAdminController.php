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
				'edificio_id' => $request->edificio_id,
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
				$image_saved = Storage::put("{$paths->pathMaster->path}/{$paths->path}", $request->file('avatar_image'));  //$request->file('avatar_image')->store("{$paths->pathMaster->path}/{$paths->path}");
				$userData->avatar_image = basename($image_saved);
				$userData->save();
			}

			// foreach($permisos as $permiso){
			// 	$userPermiso = new UserAdminPermiso();
			// 	$userPermiso->user_admin_id = $user->id;
			// 	$userPermiso->permiso_id = $permiso;
			// 	$userPermiso->save();
			// }

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

			$user = Auth::guard('admin')->user();

			$token = $user->createToken('Europa3 Admin Password Grant Client');

			return response([
				'access_token' => [
					'access_token' => $token->accessToken,
					'token_type' => 'Bearer',
					'expires_in' => $token->token->expires_at
				]
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'no se pudo iniciar sesión'
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
				'error' => 'Ocurrió un error al cerrar la sesión'
			], 500);
		}
	}

}
