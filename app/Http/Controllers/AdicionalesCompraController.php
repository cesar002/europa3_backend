<?php

namespace App\Http\Controllers;

use App\AdicionalComprado;
use App\AdicionalCompraSolicitud;
use App\Http\Requests\AdicionalCompraRequest;
use App\Http\Requests\AdicionalCompraUsadoRequest;
use App\Repositories\AdicionalesCompradosRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdicionalesCompraController extends Controller
{
	private $adicionalesCompradosRepository;

	public function __construct(AdicionalesCompradosRepository $adicionalesCompradosRepository){
		$this->adicionalesCompradosRepository = $adicionalesCompradosRepository;
	}

	public function getByUser(Request $request){
		$userId = $request->user()->id;

		$adicionales = $this->adicionalesCompradosRepository->getByUserId($userId);

		return response($adicionales);
	}

	public function show($id){
		$adicionales = $this->adicionalesCompradosRepository->getById($id);

		return response($adicionales);
	}

	public function store(AdicionalCompraRequest $request){
		try {
			DB::beginTransaction();

			$compraAdicionales = new AdicionalCompraSolicitud([
				'solicitud_id' => $request->solicitud_id,
				'folio_pago' => $request->folio_pago,
			]);

			$compraAdicionales->save();

			foreach($request->adicionales as $adicional){
				AdicionalComprado::create([
					'compra_id' => $compraAdicionales->id,
					'adicional_id' => $adicional->adicional_id,
					'cantidad' => $adicional->cantidad
				]);
			}

			DB::commit();

			return response([
				'message' => 'Información registrada con éxito'
			]);
		} catch (\Throwable $th) {
			DB::rollBack();

			Log::error($th->getMessage());
			return response([
				'error' => 'Ocurrió un error al guardar la información de compra'
			], 500);
		}
	}

	public function updateUsado(AdicionalCompraUsadoRequest $request){
		try {
			$adicionalComprado = AdicionalComprado::findOrFail($request->adicional_comprado_id);

			$newUsado = $adicionalComprado->usado + $request->usado;
			if($newUsado > $adicionalComprado->cantidad){
				throw new \Exception('La cantidad de usado es mayor a la cantidad base');
			}

			$adicionalComprado->usado = $newUsado;
			$adicionalComprado->save();

			return response([
				'message' => 'Información actualizada con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([
				'error' => 'Ocurrió un error al actualizar la información'
			], 500);
		}
	}

}
