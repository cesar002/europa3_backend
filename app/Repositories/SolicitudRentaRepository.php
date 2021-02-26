<?php

namespace App\Repositories;

use App\Interfaces\ISolicitudRentaDao;
use App\SolicitudReservacion;

class SolicitudRentaRepository implements ISolicitudRentaDao{

	public function getAll(){
		try {
			$solicitudesM = SolicitudReservacion::with('autorizado', 'metodoPago', 'metodoPago.referenciasPago',
													'fechasPago', 'fechasPago.pago','oficina', 'oficina.tipoOficina' ,'oficina.edificio', 'oficina.edificio.municipio',
													'oficina.edificio.municipio.estado', 'user', 'user.nacionalidad' ,'user.infoPersonal',
													'user.infoPersonal.tipoIdentificacion', 'user.datosFiscales', 'user.datosFiscales.estado',
													'user.datosFiscales.municipio', 'user.datosMorales', 'fechasPago', 'fechasPago.pago')->get();

			$solicitudes = $solicitudesM->map(function($solicitud){

				$fechasPago = $solicitud->fechasPago->map(function($fechaPago){
					return [
						'id' => $fechaPago->id,
						'fecha_pago' => $fechaPago->fecha_pago,
						'monto_pago' => $fechaPago->monto_pago,
						'pago_realizado' => $fechaPago->pago ?? [
							'id' => $fechaPago->pago->id,
							'folio_pago' => $fechaPago->pago->folio,
							'fecha_pago' => $fechaPago->pago->fecha_pago,
							'monto_pagado' => $fechaPago->pago->monto,
							'pago_verificado' => $fechaPago->pago->verificado,
						],
					];
				});

				return [
					'id' => $solicitud->id,
					'folio' => $solicitud->folio,
					'usuario' => [
						'id' => $solicitud->user->id,
						'email' => $solicitud->user->email,
						'datos_personales' => [
							'id' => $solicitud->user->infoPersonal->id,
							'nacionalidad' => [
								'id' => $solicitud->user->nacionalidad->id,
								'nombre' => $solicitud->user->nacionalidad->gentilicio
							],
							'identificacion' => [
								'id' => $solicitud->user->infoPersonal->tipoIdentificacion->id,
								'tipo' => $solicitud->user->infoPersonal->tipo_identificacion_otro ?? $solicitud->user->infoPersonal->tipoIdentificacion->nombre,
								'numero' => $solicitud->user->infoPersonal->numero_identificacion,
							],
							'nombre' => $solicitud->user->infoPersonal->nombre,
							'apellido_p' => $solicitud->user->infoPersonal->ape_p,
							'apellido_m' => $solicitud->user->infoPersonal->ape_m,
							'RFC' => $solicitud->user->infoPersonal->RFC,
							'CURP' => $solicitud->user->infoPersonal->CURP,
							'fecha_nacimiento' => $solicitud->user->infoPersonal->fecha_nacimiento,
							'telefono' => $solicitud->user->infoPersonal->telefono,
							'celular' => $solicitud->user->infoPersonal->celular,
							'domicilio' => $solicitud->user->infoPersonal->domicilio,
						],
						'datos_fiscales' => [
							'id' => $solicitud->user->datosFiscales->id,
							'municipio' => [
								'id' => $solicitud->user->datosFiscales->municipio->id,
								'nombre' => $solicitud->user->datosFiscales->municipio->nombre,
							],
							'estado' => [
								'id' => $solicitud->user->datosFiscales->estado->id,
								'nombre' => $solicitud->user->datosFiscales->estado->nombre,
							],
							'email' => $solicitud->user->datosFiscales->email,
							'razon_social' => $solicitud->user->datosFiscales->razon_social,
							'RFC'  => $solicitud->user->datosFiscales->RFC,
							'telefono' => $solicitud->user->datosFiscales->telefono,
							'calle' => $solicitud->user->datosFiscales->calle,
							'numero_exterior' => $solicitud->user->datosFiscales->numero_exterior ?? '',
							'numero_interior' => $solicitud->user->datosFiscales->numero_interior ?? '',
							'codigo_postal' => $solicitud->user->datosFiscales->codigo_postal,
							'colonia' => $solicitud->user->datosFiscales->colonia,
						],
						'datos_morales' => [
							'id' => $solicitud->user->datosMorales->id,
							'nombre_empresa' => $solicitud->user->datosMorales->nombre_empresa,
							'nombre' => $solicitud->user->datosMorales->nombre,
							'apellido_p' => $solicitud->user->datosMorales->ape_p,
							'apellido_m' => $solicitud->user->datosMorales->ape_m,
							'escritura_publica' => $solicitud->user->datosMorales->escritura_publica,
							'numero_notario' => $solicitud->user->datosMorales->numero_notario,
							'fecha_constitucion' => $solicitud->user->datosMorales->fecha_constitucion,
							'giro_comercial' => $solicitud->user->datosMorales->giro_comercial,
							'telefono' => $solicitud->user->datosMorales->telefono,
							'email' => $solicitud->user->datosMorales->email,
						],
					],
					'oficina' => [
						'id' => $solicitud->oficina->id,
						'nombre' => $solicitud->oficina->nombre,
						'tipo' => [
							'id' => $solicitud->oficina->tipoOficina->id,
							'nombre' => $solicitud->oficina->tipoOficina->tipo
						],
						'edificio' => [
							'id' => $solicitud->oficina->edificio->id,
							'nombre' => $solicitud->oficina->edificio->nombre,
						],
					],
					'metodo_pago' => [
						'id' => $solicitud->metodoPago->id,
						'metodo' => $solicitud->metodoPago->nombre
					],
					'fechas_pago' => $fechasPago,
					'fecha_reservacion' => $solicitud->created_at->format('Y-m-d'),
					'meses_reservacion' => $solicitud->plazo,
					'numero_ocupantes' => $solicitud->numero_ocupantes,
					'finalizado' => $solicitud->finalizado,
					'revalidado' => $solicitud->revalidado,
					'terminos_condiciones_aceptados' => $solicitud->terminos_condiciones,

				];
			});

			return $solicitudes;
		} catch (\Throwable $th) {
			return [];
		}
	}

	public function getById($id){
		try {
			$solicitud = SolicitudReservacion::with('autorizado', 'metodoPago', 'metodoPago.referenciasPago',
										'fechasPago', 'fechasPago.pago','oficina', 'oficina.tipoOficina' ,'oficina.edificio', 'oficina.edificio.municipio',
										'oficina.edificio.municipio.estado', 'user', 'user.nacionalidad' ,'user.infoPersonal',
										'user.infoPersonal.tipoIdentificacion', 'user.datosFiscales', 'user.datosFiscales.estado',
										'user.datosFiscales.municipio', 'user.datosMorales', 'fechasPago', 'fechasPago.pago')
							->findOrFail($id);

			$fechasPago = $solicitud->fechasPago->map(function($fechaPago){
				return [
					'id' => $fechaPago->id,
					'fecha_pago' => $fechaPago->fecha_pago,
					'monto_pago' => $fechaPago->monto_pago,
					'pago_realizado' => $fechaPago->pago ?? [
						'id' => $fechaPago->pago->id,
						'folio_pago' => $fechaPago->pago->folio,
						'fecha_pago' => $fechaPago->pago->fecha_pago,
						'monto_pagado' => $fechaPago->pago->monto,
						'pago_verificado' => $fechaPago->pago->verificado,
					],
				];
			});

			return [
				'id' => $solicitud->id,
				'folio' => $solicitud->folio,
				'usuario' => [
					'id' => $solicitud->user->id,
					'email' => $solicitud->user->email,
					'datos_personales' => [
						'id' => $solicitud->user->infoPersonal->id,
						'nacionalidad' => [
							'id' => $solicitud->user->nacionalidad->id,
							'nombre' => $solicitud->user->nacionalidad->gentilicio
						],
						'identificacion' => [
							'id' => $solicitud->user->infoPersonal->tipoIdentificacion->id,
							'tipo' => $solicitud->user->infoPersonal->tipo_identificacion_otro ?? $solicitud->user->infoPersonal->tipoIdentificacion->nombre,
							'numero' => $solicitud->user->infoPersonal->numero_identificacion,
						],
						'nombre' => $solicitud->user->infoPersonal->nombre,
						'apellido_p' => $solicitud->user->infoPersonal->ape_p,
						'apellido_m' => $solicitud->user->infoPersonal->ape_m,
						'RFC' => $solicitud->user->infoPersonal->RFC,
						'CURP' => $solicitud->user->infoPersonal->CURP,
						'fecha_nacimiento' => $solicitud->user->infoPersonal->fecha_nacimiento,
						'telefono' => $solicitud->user->infoPersonal->telefono,
						'celular' => $solicitud->user->infoPersonal->celular,
						'domicilio' => $solicitud->user->infoPersonal->domicilio,
					],
					'datos_fiscales' => [
						'id' => $solicitud->user->datosFiscales->id,
						'municipio' => [
							'id' => $solicitud->user->datosFiscales->municipio->id,
							'nombre' => $solicitud->user->datosFiscales->municipio->nombre,
						],
						'estado' => [
							'id' => $solicitud->user->datosFiscales->estado->id,
							'nombre' => $solicitud->user->datosFiscales->estado->nombre,
						],
						'email' => $solicitud->user->datosFiscales->email,
						'razon_social' => $solicitud->user->datosFiscales->razon_social,
						'RFC'  => $solicitud->user->datosFiscales->RFC,
						'telefono' => $solicitud->user->datosFiscales->telefono,
						'calle' => $solicitud->user->datosFiscales->calle,
						'numero_exterior' => $solicitud->user->datosFiscales->numero_exterior ?? '',
						'numero_interior' => $solicitud->user->datosFiscales->numero_interior ?? '',
						'codigo_postal' => $solicitud->user->datosFiscales->codigo_postal,
						'colonia' => $solicitud->user->datosFiscales->colonia,
					],
					'datos_morales' => [
						'id' => $solicitud->user->datosMorales->id,
						'nombre_empresa' => $solicitud->user->datosMorales->nombre_empresa,
						'nombre' => $solicitud->user->datosMorales->nombre,
						'apellido_p' => $solicitud->user->datosMorales->ape_p,
						'apellido_m' => $solicitud->user->datosMorales->ape_m,
						'escritura_publica' => $solicitud->user->datosMorales->escritura_publica,
						'numero_notario' => $solicitud->user->datosMorales->numero_notario,
						'fecha_constitucion' => $solicitud->user->datosMorales->fecha_constitucion,
						'giro_comercial' => $solicitud->user->datosMorales->giro_comercial,
						'telefono' => $solicitud->user->datosMorales->telefono,
						'email' => $solicitud->user->datosMorales->email,
					],
				],
				'oficina' => [
					'id' => $solicitud->oficina->id,
					'nombre' => $solicitud->oficina->nombre,
					'tipo' => [
						'id' => $solicitud->oficina->tipoOficina->id,
						'nombre' => $solicitud->oficina->tipoOficina->tipo
					],
					'edificio' => [
						'id' => $solicitud->oficina->edificio->id,
						'nombre' => $solicitud->oficina->edificio->nombre,
					],
				],
				'metodo_pago' => [
					'id' => $solicitud->metodoPago->id,
					'metodo' => $solicitud->metodoPago->nombre
				],
				'fechas_pago' => $fechasPago,
				'fecha_reservacion' => $solicitud->created_at->format('Y-m-d'),
				'meses_reservacion' => $solicitud->plazo,
				'numero_ocupantes' => $solicitud->numero_ocupantes,
				'finalizado' => $solicitud->finalizado,
				'revalidado' => $solicitud->revalidado,
				'terminos_condiciones_aceptados' => $solicitud->terminos_condiciones,

			];
		} catch (\Throwable $th) {
			return [];
		}
	}

}
