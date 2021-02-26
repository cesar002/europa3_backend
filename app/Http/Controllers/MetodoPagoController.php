<?php

namespace App\Http\Controllers;

use App\MetodoPago;
use Illuminate\Support\Facades\Log;

class MetodoPagoController extends Controller{

	private $tipoPagoRepository;

	public function __construct(\App\Repositories\TipoPagoRepository $tipoPagoRepository){
		$this->tipoPagoRepository = $tipoPagoRepository;
	}

	public function index(){
		$tipoPago = $this->tipoPagoRepository->getAll();

		return response($tipoPago);
	}

	public function show($id){
		$tipoPago = $this->tipoPagoRepository->getById($id);

		return response($tipoPago);
	}

	public function store(\App\Http\Requests\TipoPagoRequest $request){
		try {
			$tipoPago = new MetodoPago([
				'nombre' => $request->nombre,
				'presencial' => $request->presencial,
				'virtual' => $request->virtual
			]);

			$tipoPago->save();

			return response([
				'message' => 'Metodo de pago registrado con éxito'
			], 201);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al registrar el Metodo de pago'
			], 500);
		}
	}

	public function update(\App\Http\Requests\TipoPagoRequest $request, $id){
		try {

			$tipoPago = MetodoPago::findOrFail($id);

			$tipoPago->nombre =    	$request->nombre;
			$tipoPago->presencial =	$request->presencial;
			$tipoPago->virtual =   	$request->virtua;

			$tipoPago->save();

			return response([
				'message' => 'Metodo de pago actualizado'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al actualizar el Metodo de pago'
			], 500);
		}
	}

}
