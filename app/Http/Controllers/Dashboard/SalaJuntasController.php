<?php

namespace App\Http\Controllers\Dashboard;

use App\CatServiciosOficina;
use App\CatSizeOficina;
use App\Edificio;
use App\Http\Controllers\Controller;
use App\SalaJuntas;
use Illuminate\Http\Request;

class SalaJuntasController extends Controller
{
    public function index()
	{
		$salas = SalaJuntas::with('edificio')->get();

		return view('dashboard.salaJuntas.home', [
			'salas' => $salas,
			'edificios' => Edificio::all(),
			'sizes' => CatSizeOficina::all(),
			'servicios' => CatServiciosOficina::all(),
		]);
	}

	public function show($id)
	{
		try {
			$sala = SalaJuntas::with('servicios', 'mobiliarioAsignado', 'mobiliarioAsignado.mobiliario')->findOrFail($id);

			return view('dashboard.salaJuntas.show', [
				'sala' => $sala,
				'edificios' => Edificio::all(),
				'sizes' => CatSizeOficina::all(),
				'servicios' => CatServiciosOficina::all(),
			]);
		} catch (\Throwable $th) {
			return abort(404);
		}
	}


	public function showUpdateImage($id)
	{
		try{
			$sala = SalaJuntas::with('imagenes', 'pathImages', 'pathImages.pathMaster')->findOrFail($id);

			return view('dashboard.salaJuntas.imagenesUpdate', [
				'sala' => $sala
			]);
		}catch (\Throwable $th){
			return abort(404);
		}
	}

}
