<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificacionSolicitudEdificio extends Model
{
    protected $fillable = [
		'user_id', 'edificio_id', 'solicitud_id', 'body', 'type'
	];


	public function user(){
		return $this->belongsTo(\App\User::class, 'user_id');
	}

	public function edificio(){
		return $this->belongsTo(\App\Edificio::class, 'edificio_id');
	}

	public function solicitud(){
		return $this->belongsTo(\App\SolicitudReservacion::class, 'solicitud_id');
	}

}
