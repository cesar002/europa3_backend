<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model{

	protected $table = 'cat_metodos_pago';

	protected $casts = [
		'presencial' => 'boolean',
		'en_linea' => 'boolean',
	];

	protected $hidden = [
		'created_at', 'updated_at'
	];

	protected $fillable = [
		'nombre', 'presencial', 'en_linea'
	];

	public function solicitudesOficina(){
		return $this->hasMany(\App\SolicitudOficina::class, 'metodo_pago_id');
	}

	public function referenciasPago(){
		return $this->hasMany(\App\CatReferenciaPago::class, 'metodo_pago_id');
	}

}
