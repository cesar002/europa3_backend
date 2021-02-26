<?php

namespace App\Http\Controllers;

use App\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EstadosController extends Controller
{
    public function index(){
		$estados = Estado::all();

		return response($estados);
	}

	public function show($id){
		try {
			$estado = Estado::findOrFail($id);

			return response($estado);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response(json_encode([], JSON_FORCE_OBJECT));
		}
	}
}
