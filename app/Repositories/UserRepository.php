<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\DB;
use App\Interfaces\IUserDao;
use Illuminate\Support\Facades\Log;

class UserRepository implements IUserDao{

	/**
	 * obtiene los datos basicos del modelo usuario
	 */
	public function getUserData(User $user){
		try {

			$personalData = $user->infoPersonal()->with('nacionalidad', 'tipoIdentificacion')->first();

			return [
				'id' => $user->id,
				'email' => $user->email,
				'notification_token' => $user->getNotificationToken(),
				'verify' => $user->email_verified,
				'personal_data' => is_null($personalData) ? [] : [
					'nombre' => $personalData->nombre,
					'apellido_paterno' => $personalData->ape_p,
					'apellido_materno' => $personalData->ape_m,
					'nacionalidad' => [
						'id' => $personalData->nacionalidad->id,
						'nombre' => $personalData->nacionalidad->gentilicio
					],
					'identificacion' => [
						'id' => $personalData->tipoIdentificacion->id,
						'tipo' => $personalData->tipo_identificacion_otro ?? $personalData->tipoIdentificacion->nombre,
						'numero' => $personalData->numero_identificacion
					],
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

			$user = User::find($userId)->with('infoPersonal', 'infoPersonal.nacionalidad', 'infoPersonal.tipoIdentificacion')->firstOrFail();

			return [
				'id' => $user->id,
				'email' => $user->email,
				'notification_token' => $user->getNotificationToken(),
				'verify' => $user->email_verified,
				'personal_data' => is_null($user->infoPersonal) ? [] : [
					'nombre' => $user->infoPersonal->nombre,
					'apellido_paterno' => $user->infoPersonal->ape_p,
					'apellido_materno' => $user->infoPersonal->ape_m,
					'nacionalidad'  => [
						'id' => $user->infoPersonal->nacionalidad->id,
						'nombre' => $user->infoPersonal->nacionalidad->gentilicio
					],
					'identificacion' => [
						'id' => $user->infoPersonal->tipoIdentificacion->id,
						'tipo' => $user->infoPersonal->tipo_identificacion_otro ?? $user->infoPersonal->tipoIdentificacion->nombre,
						'numero' => $user->infoPersonal->numero_identificacion
					],
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

	public function getAll(){
		try {
			$usuarios = User::with('infoPersonal', 'infoPersonal.nacionalidad', 'infoPersonal.tipoIdentificacion')->get();

			return $usuarios->map(function($user){
				return [
					'id' => $user->id,
					'email' => $user->email,
					'notification_token' => $user->getNotificationToken(),
					'verify' => $user->email_verified,
					'personal_data' => is_null($user->infoPersonal) ? null : [
						'nombre' => $user->infoPersonal->nombre,
						'apellido_paterno' => $user->infoPersonal->ape_p,
						'apellido_materno' => $user->infoPersonal->ape_m,
						'nacionalidad'  => [
							'id' => $user->infoPersonal->nacionalidad->id,
							'nombre' => $user->infoPersonal->nacionalidad->gentilicio
						],
						'identificacion' => [
							'id' => $user->infoPersonal->tipoIdentificacion->id,
							'tipo' => $user->infoPersonal->tipo_identificacion_otro ?? $user->infoPersonal->tipoIdentificacion->nombre,
							'numero' => $user->infoPersonal->numero_identificacion
						],
						'RFC' => $user->infoPersonal->RFC,
						'CURP' => $user->infoPersonal->CURP,
						'fecha_nacimiento' => $user->infoPersonal->fecha_nacimiento,
						'telefono' => $user->infoPersonal->telefono,
						'celular' => $user->infoPersonal->celular,
						'domicilio' => $user->infoPersonal->domicilio,
					],
				];
			});
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}
}
