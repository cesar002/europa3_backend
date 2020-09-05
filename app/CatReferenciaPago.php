<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatReferenciaPago extends Model{
	protected $table = 'cat_referencias_pagos';

	protected $hidden = [
		'created_at', 'updated_at', 'metodo_pago_id',
	];

	protected $fillable = [
		'metodo_pago_id', 'referencia', 'entidad_bancaria'
	];

	public function metodoPago(){
		return $this->belongsTo(\App\MetodoPago::class, 'metodo_pago_id');
	}

}
