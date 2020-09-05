<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutorizacionEstado extends Model{
	protected $table = 'autorizaciones_estado';

	protected $casts = [
		'autorizado' => 'boolean',
	];

	protected $hidden = [
		'created_at', 'updated_at',
	];

	public function solicitud(){
		return $this->belongsTo(\App\SolicitudReservacion::class, 'solicitud_id');
	}
}
