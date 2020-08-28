<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\DB;
use App\Interfaces\IUserDao;

class UserRepository implements IUserDao{

	/**
	 * obtiene los datos basicos del modelo usuario
	 */
	public function getUserData(User $user){
		try {

			$personalData = $user->infoPersonal()->with('nacionalidad')->first();

			return [
				'id' => $user->id,
				'email' => $user->email,
				'notification_token' => $user->getNotificationToken(),
				'verify' => $user->email_verified,
				'personal_data' => is_null($personalData) ? [] : [
					'nombre' => $personalData->nombre,
					'apellido_paterno' => $personalData->ape_p,
					'apellido_materno' => $personalData->ape_m,
					'nacionalidad' => $personalData->nacionalidad->gentilico,
					'RFC' => $personalData->RFC,
					'CURP' => $personalData->CURP,
					'fecha_nacimiento' => $personalData->fecha_nacimiento,
					'telefono' => $personalData->telefono,
					'celular' => $personalData->celular,
					'domicilio' => $personalData->domicilio,
				],
			];
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getUserDataById(int $userId){
		try {

			$user = User::find($userId)->with('infoPersonal', 'infoPersonal.nacionalidad')->firstOrFail();

			return [
				'id' => $user->id,
				'email' => $user->email,
				'notification_token' => $user->getNotificationToken(),
				'verify' => $user->email_verified,
				'personal_data' => is_null($user->infoPersonal) ? [] : [
					'nombre' => $user->infoPersonal->nombre,
					'apellido_paterno' => $user->infoPersonal->ape_p,
					'apellido_materno' => $user->infoPersonal->ape_m,
					'nacionalidad' => $user->infoPersonal->nacionalidad->gentilico,
					'RFC' => $user->infoPersonal->RFC,
					'CURP' => $user->infoPersonal->CURP,
					'fecha_nacimiento' => $user->infoPersonal->fecha_nacimiento,
					'telefono' => $user->infoPersonal->telefono,
					'celular' => $user->infoPersonal->celular,
					'domicilio' => $user->infoPersonal->domicilio,
				],
			];
		} catch (\Throwable $th) {
			return [];
		}
	}
}
