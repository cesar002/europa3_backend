<?php

namespace App\Http\Controllers;

use App\UserAdmin;
use Illuminate\Http\Request;
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

	public function login(){

	}

}
