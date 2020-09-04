<?php

namespace App\Http\Controllers;

use App\Mobiliario;
use Illuminate\Support\Facades\Log;

class MobiliarioController extends Controller
{

	private $mobiliarioRepository;

	public function __construct(\App\Repositories\MobiliarioRepository $mobiliarioRepository){
		$this->mobiliarioRepository = $mobiliarioRepository;
	}

	public function getByEdificio($id){
		$mobiliario = $this->mobiliarioRepository->getAllByEdificioId($id);

		return response($mobiliario);
	}

	public function index(){
		$mobiliario = $this->mobiliarioRepository->getAll();

		return $mobiliario;
	}

	public function store(\App\Http\Requests\MobiliarioStoreRequest $request){
		try {

			$mobiliario = new Mobiliario([
				'tipo_id' => $request->tipo_id,
				'edificio_id' => $request->edificio_id,
				'marca' => $request->marca,
				'modelo' => $request->modelo,
				'color' => $request->color,
				'descripcion_bien' => $request->descripcion_bien,
				'observaciones' => $request->observaciones,
				'cantidad' => $request->cantidad,
			]);

			$mobiliario->save();

			return response([
				'message' => 'Mobiliario registrado con éxito'
			], 201);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([

			], 500);
		}
	}

	public function show($id){
		$mobiliario = $this->mobiliarioRepository->getById($id);

		return response($mobiliario);
	}

	public function update(\App\Http\Requests\MobiliarioUpdateRequest $request, $id){
		try {
			$mobiliario = Mobiliario::findOrFail($id);

			$mobiliario->tipo_id = $request->tipo_id;
			$mobiliario->edificio_id = $request->edificio_id;
			$mobiliario->marca = $request->marca;
			$mobiliario->modelo = $request->modelo;
			$mobiliario->color = $request->color;
			$mobiliario->descripcion_bien = $request->descripcion_bien;
			$mobiliario->observaciones = $request->observaciones;
			$mobiliario->cantidad = $request->cantidad;

			$mobiliario->save();

			return response([
				'message' => 'Mobiliario actualizado con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([

			], 500);
		}
	}

	public function destroy($id){
		try {
			$mobiliario = Mobiliario::findOrFail($id);

			$mobiliario->delete();

			return response([
				'message' => 'Mobiliario eliminado éxitosamente'
			], 204);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([

			], 500);
		}
	}

}
