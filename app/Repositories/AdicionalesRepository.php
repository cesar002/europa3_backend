<?php

namespace App\Repositories;

use App\Adicional;
use App\Interfaces\IAdicionalesDao;
use Illuminate\Support\Facades\Log;

class AdicionalesRepository implements IAdicionalesDao {

	public function getById($id){
		try {
			$adicional = Adicional::with('edificio', 'unidad')->findOrFail($id);
			
			return $adicional;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

	public function getAll(){
		try {
			$adicionales = Adicional::with('edificio', 'unidad')->get();

			return $adicionales;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

	public function getByEdificioId($edificioId){
		try {
			$adicionales = Adicional::with('edificio', 'unidad')->where('edificio_id', $edificioId)->get();

			return $adicionales;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}
}