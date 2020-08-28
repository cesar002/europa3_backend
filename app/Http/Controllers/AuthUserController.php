<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthUserController extends Controller
{

	public function register(\App\Http\Requests\RegisterUserRequest $request){
		try {

			$user = new User([
				'email' => $request->email,
				'password' => $request->password
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

}
