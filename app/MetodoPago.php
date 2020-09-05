<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model{

	protected $table = 'cat_metodos_pagos';

	protected $casts = [
		'presencial' => 'boolean',
		'virtual' => 'boolean',
	];

	protected $hidden = [
		'created_at', 'updated_at'
	];

	protected $fillable = [
		'nombre', 'presencial', 'virtual'
	];

	public function solicitudes(){
		return $this->hasMany(\App\SolicitudReservacion::class, 'metodo_pago_id');
	}

	public function referenciasPago(){
		return $this->hasMany(\App\CatReferenciaPago::class, 'metodo_pago_id');
	}

}
