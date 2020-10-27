<?php

namespace App\Repositories;

use App\Interfaces\IDatosMoralesDao;
use App\UserDatosMorales;

class DatosMoralesRepository implements IDatosMoralesDao{
	public function getDatosMoralesByUserId($userId){
		try {
			$data = UserDatosMorales::with('')->where('user_id', $userId)->firstOrFail();

			return $data;
		} catch (\Throwable $th) {
			return [];
		}
	}
}
