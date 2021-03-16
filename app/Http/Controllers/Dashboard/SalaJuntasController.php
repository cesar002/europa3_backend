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
		$salas = SalaJuntas::with('imagenes', 'pathImages', 'pathImages.pathMaster', 'edificio')->get();

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
			$sala = SalaJuntas::findOrFail($id);

			return view('dashboard.salaJuntas.show', [
				'sala' => $sala,
			]);
		} catch (\Throwable $th) {
			return abort(404);
		}
	}
}
