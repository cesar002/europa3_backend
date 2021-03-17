<?php

namespace App\Http\Controllers\Dashboard;

use App\Edificio;
use App\OficinaVirtual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\OficinaVirtualRequest;

class OficinasVirtualesController extends Controller
{
    public function index()
	{
		return view('dashboard.oficinasVirtuales.home', [
			'oficinasVirtuales' => OficinaVirtual::with('edificio')->get(),
			'edificios' => Edificio::all(),
		]);
	}

	public function store(OficinaVirtualRequest $request)
	{
		try {

			$oficina = new OficinaVirtual([
				'edificio_id' => $request->edificio_id,
				'tipo_oficina_id' => 3,
				'tipo_tiempo_id' => 1,
				'nombre' => $request->nombre,
				'descripcion' => $request->descripcion,
				'precio' => $request->precio
			]);
			$oficina->save();

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Oficina virtual registrada con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al registrar la oficina virtual'
			]);
		}finally{
			return redirect()->back();
		}
	}

}
