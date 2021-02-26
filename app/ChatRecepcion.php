<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRecepcion extends Model
{
	protected $table = 'chat_recepcion';

	protected $fillable = [
		'sender_by',
		'mensaje',
		'edificio_id',
		'solicitud_id',
	];

	protected $hidden = [
		'updated_at',
	];

	public function chatable(){
		return $this->morphTo();
	}

	public function edificio(){
		return $this->belongsTo(\App\Edificio::class, 'edificio_id');
	}

	public function solicitud(){
		return $this->belongsTo(\App\SolicitudReservacion::class, 'solicitud_id');
	}

}
