<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatEstadoSolicitud extends Model
{
	protected $table = 'cat_estados_solicitud';

	protected $hidden = [
		'created_at', 'updated_at',
	];

	public function solicitudes(){
		return $this->hasMany(\App\SolicitudReservacion::class, 'estado_id');
	}

}
