<?php

namespace App\Repositories;

use App\Interfaces\IUserAdminDao;
use App\UserAdmin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserAdminRepository implements IUserAdminDao{

	public function getEdificioUser($id){
		try {
			$edificio = DB::select('SELECT DISTINCT e.id, e.nombre FROM users_admin_edificios AS uae
										INNER JOIN users_admin AS ua ON ua.id = uae.user_admin_id
										INNER JOIN edificios AS e ON e.id = uae.edificio_id
									WHERE ua.id = ?', [$id]);

			return (collect($edificio)->map(function($ed){
				return [
					'id' => $ed->id,
					'nombre' => $ed->nombre,
				];
			}))[0];
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getAllUsers()
	{
		try {
			$users = UserAdmin::with('infoPersonal', 'infoPersonal.pathImage', 'infoPersonal.pathImage.pathMaster')->get();

			return $users->map(function($user){
				return [
					'id' => $user->id,
					'username' => $user->username,
					'infoPersonal' => [
						'id' => $user->infoPersonal->id,
						'nombre' => $user->infoPersonal->nombre,
						'ape_pat' => $user->infoPersonal->ap_p,
						'ape_mat' => $user->infoPersonal->ap_m,
						'avatar' => $user->infoPersonal->avatar_image ? Storage::url("{$user->infoPersonal->pathImage->pathMaster->path}/{$user->infoPersonal->pathImage->path}/{$user->infoPersonal->avatar_image}") : null,
					],
				];
			});
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

	public function getUserData(UserAdmin $user){
		try {
			$userData = $user->infoPersonal()->with('pathImage', 'pathImage.pathMaster')->first();
			$edificio = $user->edificio()->first();

			// $edificio = DB::select('SELECT DISTINCT e.id, e.nombre FROM users_admin_edificios AS uae
			// 							INNER JOIN users_admin AS ua ON ua.id = uae.user_admin_id
			// 							INNER JOIN edificios AS e ON e.id = uae.edificio_id
			// 						WHERE ua.id = ?', [$user->id]);

			$permisos = ($user->permisos()->with('permiso')->get())->map(function($permiso){
				return[
					'id' => $permiso->permiso->id,
					'nombre' => $permiso->permiso->nombre,
				];
			});

			return [
				'id' => $user->id,
				'username' => $user->username,
				'infoPersonal' => [
					'id' => $userData->id,
					'nombre' => $userData->nombre,
					'ape_pat' => $userData->ap_p,
					'ape_mat' => $userData->ap_m,
					'avatar' => asset(Storage::url("{$userData->pathImage->pathMaster->path}/{$userData->pathImage->path}/{$userData->avatar_image}"))
				],
				'edificio' => $edificio,
				'permisos' => $permisos,
			];
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

	public function getUserDataById($id){
		try {
			//code...
		} catch (\Throwable $th) {
			return [];
		}
	}

}
