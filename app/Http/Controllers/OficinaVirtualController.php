<?php

namespace App\Http\Controllers;

use App\Http\Requests\OficinaVirtualRequest;
use App\OficinaServicio;
use App\OficinaVirtual;
use App\Repositories\OficinaVirtualRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OficinaVirtualController extends Controller
{

	private $oficinaVirtualRepository;

	public function __construct(OficinaVirtualRepository $oficinaVirtualRepository){
		$this->oficinaVirtualRepository = $oficinaVirtualRepository;
	}

    public function index(){
		$oficinas = $this->oficinaVirtualRepository->getAll();

		return response($oficinas);
	}

	public function show($id){
		try {
			$oficina = OficinaVirtual::with(
						'servicios', 'edificio', 'edificio.municipio' ,'tipoOficina'
						)->findOrFail($id);

			return response($oficina);
		} catch (\Throwable $th) {
			return response(json_encode([], JSON_FORCE_OBJECT));
		}
	}

	public function store(OficinaVirtualRequest $request){
		try {

			DB::beginTransaction();

			$oficina = new OficinaVirtual([
				'edificio_id' => $request->edificio_id,
				'tipo_oficina_id' => 3,
				'tipo_tiempo_id' => 2,
				'nombre' => $request->nombre,
				'descripcion' => $request->descripcion,
				'precio' => $request->precio,
			]);

			$oficina->save();

			if($request->servicios){
				foreach($request->servicios as $i => $value){
					$servicio = new OficinaServicio([
						'oficina_virtual_id' => $oficina->id,
						'servicio_id' => $value
					]);

					$servicio->save();
				}
			}

			DB::commit();

			return response([
				'message' => 'Oficina virtual guardada con éxito'
			]);
		} catch (\Throwable $th) {
			DB::rollBack();

			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al intentar registrar la oficina virtual'
			], 501);
		}
	}

	public function update(OficinaVirtualRequest $request, $id){
		try {
			DB::beginTransaction();

			$oficina = OficinaVirtual::findOrFail($id);

			$oficina->edificio_id = $request->edificio_id;
			$oficina->nombre = $request->nombre;
			$oficina->descripcion = $request->descripcion;
			$oficina->precio = $request->precio;

			if($request->servicios){
				DB::delete('DELETE * FROM oficina_virtual_servicios WHERE oficina_virtual_id = ?', [ $oficina->id ]);

				foreach($request->servicios as $i => $value){
					$servicio = new OficinaServicio([
						'oficina_virtual_id' => $oficina->id,
						'servicio_id' => $value
					]);

					$servicio->save();
				}
			}

			$oficina->save();

			DB::commit();

			return response([
				'message' => 'Oficina virtual actualizada con éxito',
			]);
		} catch (\Throwable $th) {
			DB::rollBack();

			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al actualizar la oficina virtual',
			], 501);
		}
	}

	public function destroy($id){
		try {
			$oficina = OficinaVirtual::findOrFail($id);

			$oficina->delete();

			return response([
				'message' => 'Oficina virtual eliminada con éxito',
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al eliminar la oficina virtual'
			], 501);
		}
	}
}
