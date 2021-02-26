<?php

namespace App\Http\Controllers;

use App\Adicional;
use App\Http\Requests\AdicionalesRequest;
use App\Repositories\AdicionalesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdicionalesController extends Controller
{
	private $adicionalesRepository;

	public function __construct(AdicionalesRepository $adicionalesRepository){
		$this->adicionalesRepository = $adicionalesRepository;
	}

	public function index(){
		$adicionales = $this->adicionalesRepository->getAll();

		return response($adicionales);
	}

	public function show($id){
		$adicional = $this->adicionalesRepository->getById($id);

		return response($adicional);
	}

	public function getByEdificioId($id){
		$adicionales = $this->adicionalesRepository->getByEdificioId($id);

		return response($adicionales);
	}

	public function store(AdicionalesRequest $request){
		try {
			$adicional = new Adicional([
				'edificio_id' => $request->edificio_id,
				'unidad_id' => $request->unidad_id,
				'nombre' => $request->nombre,
				'descripcion' => $request->descripcion,
				'precio' => $request->precio,
				'unidad_base' => $request->unidad_base,
				'cantidad_maxima' => $request->cantidad_maxima,
			]);

			$adicional->save();

			return response([
				'message' => 'Adicional registrado con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([
				'error' => 'Ocurrió un error al registrar el adicional'
			], 500);
		}
	}

	public function update(AdicionalesRequest $request, $id){
		try {
			$adicional = Adicional::findOrFail($id);

			$adicional->edificio_id = $request->edificio_id;
			$adicional->unidad_id = $request->unidad_id;
			$adicional->nombre = $request->nombre;
			$adicional->descripcion = $request->descripcion;
			$adicional->precio = $request->precio;

			$adicional->save();

			return response([
				'message' => 'Adicional actualizado con éxito',
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([
				'error' => 'Ocurrió un error al actualizar la información'
			]);
		}
	}

	public function destroy($id){
		try {
			$adicional = Adicional::findOrFail($id);
			$adicional->delete();

			return response([
				'message' => 'Adicional eliminado con éxito',
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([
				'error' => 'Ocurrió un error al eliminar el adicional'
			], 500);
		}
	}

}
