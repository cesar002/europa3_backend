<?php

namespace App\Http\Controllers;

use App\CatUnidadAdicional;
use Illuminate\Http\Request;

class CatUnidadesController extends Controller
{
    public function index(){
		$unidades = CatUnidadAdicional::all();

		return response($unidades);
	}
}
