<?php

namespace App\Http\Controllers;

use App\SolicitudReservacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SolicitudController extends Controller
{

    public function index(Request $request){
		try {

			$idEdificio = 1;

			$data = SolicitudReservacion::with('solicitudOficina', 'solicitudOficina.oficina' ,'user', 'user.infoPersonal', 'user.datosMorales', 'user.datosFiscales')
				->whereHas('solicitudOficina', function($query) use($idEdificio){
					$query->whereHas('oficina', function($query) use($idEdificio){
						$query->where('edificio_id', $idEdificio);
					});
			})->get();

			return response($data);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([]);
		}
	}


}
