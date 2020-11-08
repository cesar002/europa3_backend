<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudOficina extends Model
{
	protected $table = 'solicitud_oficina';

	protected $fillable = [
		'solicitud_id', 'oficina_id', 'metodo_pago_id',
		'fecha_reservacion', 'meses_renta', 'numero_integrantes',
	];

	protected $hidden = [
		'created_at', 'updated_at',
	];


	public function sollicitudReservacion(){
		return $this->belongsTo(\App\SolicitudReservacion::class, 'solicitud_id');
	}

	public function oficina(){
		return $this->belongsTo(\App\Oficina::class, 'oficina_id');
	}

	public function metodoPago(){
		return $this->belongsTo(\App\MetodoPago::class, 'metodo_pago_id');
	}

}
