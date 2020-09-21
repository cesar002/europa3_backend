<?php

namespace App\Repositories;

use App\Interfaces\IUserAdminDao;
use App\UserAdmin;
use Illuminate\Support\Facades\Storage;

class UserAdminRepository implements IUserAdminDao{

	public function getUserData(UserAdmin $user){
		try {
			$userData = $user->infoPersonal()->with('pathImage', 'pathImage.pathMaster')->first();

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
				'permisos' => $permisos,
			];
		} catch (\Throwable $th) {
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
