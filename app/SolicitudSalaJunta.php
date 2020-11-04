<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudSalaJunta extends Model
{
	protected $table = 'solicitud_sala_juntas';

	protected $fillable = [
		'solicitud_id', 'sala_id', 'metodo_pago_id',
		'fecha_reservacion', 'hora_inicio', 'hora_fin',
	];

	protected $hidden = [
		'created_at', 'updated_at',
	];


	public function sollicitudReservacion(){
		return $this->belongsTo(\App\SolicitudReservacion::class, 'solicitud_id');
	}

}
