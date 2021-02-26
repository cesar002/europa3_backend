<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FechaPago extends Model
{
	protected $table = 'fechas_pagos';

	protected $fillable = [
		'solicitud_id', 'fecha_pago', 'monto_pago'
	];

	protected $hidden = [
		'created_at', 'updated_at',
	];

    public function solicitudReservacion(){
        return $this->belongsTo(\App\SolicitudReservacion::class, 'solicitud_id');
    }

    public function pago(){
        return $this->hasOne(\App\RegistroPago::class, 'fecha_id');
    }
}
