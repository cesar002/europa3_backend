<?php

namespace App\Http\Controllers\Dashboard;

use App\Adicional;
use App\CatUnidadAdicional;
use App\Edificio;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdicionalesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdicionalesController extends Controller
{
    public function index()
	{

		$adicionales = Adicional::all();
		$edificios = Edificio::all();
		$unidades = CatUnidadAdicional::all();

		return view('dashboard.adicionales.home',[
			'adicionales' => $adicionales,
			'edificios' => $edificios,
			'unidades' => $unidades,
		]);
	}

	public function store(AdicionalesRequest $request)
	{
		try {

			$adicional = new Adicional($request->all());
			$adicional->save();

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Adicional registrado con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al registrar el adicional'
			]);
		}finally{
			return redirect()->back();
		}
	}
}
