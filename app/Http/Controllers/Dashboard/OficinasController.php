<?php

namespace App\Http\Controllers\Dashboard;

use App\CatServiciosOficina;
use App\CatSizeOficina;
use App\Edificio;
use App\Http\Controllers\Controller;
use App\Mobiliario;
use App\Oficina;
use Illuminate\Http\Request;

class OficinasController extends Controller
{
    public function index()
	{
		$oficinas =  Oficina::with('edificio', 'imagenes', 'imagenes.path', 'imagenes.path.pathMaster')->get();
		$edificios = Edificio::all();
		$sizes = CatSizeOficina::all();
		$servicios = CatServiciosOficina::all();

		return view('dashboard.oficinas.home', [
			'oficinas' => $oficinas,
			'edificios' => $edificios,
			'sizes' => $sizes,
			'servicios' => $servicios,
		]);
	}

	public function show($id)
	{
		try {
			$oficina = Oficina::with('mobiliarioAsignado', 'mobiliarioAsignado.mobiliario', 'servicios')->findOrFail($id);
			$edificios = Edificio::all();
			$sizes = CatSizeOficina::all();
			$servicios = CatServiciosOficina::all();
			$mobiliario = Mobiliario::where('edificio_id', $oficina->edificio_id)->get();

			return view('dashboard.oficinas.show', [
				'oficina' => $oficina,
				'edificios' => $edificios,
				'sizes' => $sizes,
				'servicios' => $servicios,
				'mobiliario' => $mobiliario,
			]);
		} catch (\Throwable $th) {
			return abort(404);
		}
	}

	public function showImagenesUpdate($id)
	{
		try {
			return view('dashboard.oficinas.imagenesUpdate');
		} catch (\Throwable $th) {
			return abort(404);
		}
	}

}
