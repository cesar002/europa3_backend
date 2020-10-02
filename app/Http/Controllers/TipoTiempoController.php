<?php

namespace App\Http\Controllers;

use App\TipoTiempoRenta;
use Illuminate\Http\Request;

class TipoTiempoController extends Controller
{
    public function index(){
		$data = TipoTiempoRenta::all();

		return response($data);
	}
}
