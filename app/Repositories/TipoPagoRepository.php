<?php

namespace App\Repositories;

use App\Interfaces\ITipoPagoDao;
use App\TipoPago;

class TipoPagoRepository implements ITipoPagoDao{

	public function getAll(){
		try {
			$tiposPago = TipoPago::with('referenciasPago')->get();

			return $tiposPago;
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getById($id){
		try {
			$tipoPago = TipoPago::with('referenciasPago')->findOrFail($id);

			return $tiposPago;
		} catch (\Throwable $th) {
			return [];
		}
	}

}
