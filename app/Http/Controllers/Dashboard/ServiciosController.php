<?php

namespace App\Http\Controllers\Dashboard;

use App\CatServiciosOficina;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiciosController extends Controller
{
    public function index()
	{
		$servicios = CatServiciosOficina::all();

		return view('dashboard.servicios.home', [
			'servicios' => $servicios,
		]);
	}
}
