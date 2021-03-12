<?php

namespace App\Http\Controllers\Dashboard;

use App\Edificio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EdificiosController extends Controller
{
    public function index()
	{

		$edificios = Edificio::with('municipio', 'municipio.estado')->get();

		return view('dashboard.edificios.home', [
			'edificios' => $edificios,
		]);
	}

	public function show($id)
	{
		try {
			$edificio = Edificio::findOrFail($id);

			return view('dashboard.edificios.show', [
				'edificio' => $edificio,
			]);
		} catch (\Throwable $th) {
			return abort(404);
		}
	}
}
