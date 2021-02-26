<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdicionalCompraSolicitud extends Model
{
	protected $table = 'adicionales_compra_solicitud';

	protected $fillable = [
		'solicitud_id', 'folio_pago',
	];

	protected $hidden = [
		'updated_at'
	];

	public function solicitud(){
		return $this->belongsTo(\App\SolicitudReservacion::class, 'solicitud_id');
	}

	public function adicionalesComprados(){
		return $this->hasMany(\App\AdicionalComprado::class, 'compra_id');
	}

}
