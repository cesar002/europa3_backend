<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FechaPago extends Model
{
    protected $table = 'fechas_pagos';

    public function solicitudReservacion(){
        return $this->belongsTo(\App\SolicitudReservacion::class, 'solicitud_id');
    }

    public function pago(){
        return $this->hasOne(\App\RegistroPago::class, 'fecha_id');
    }
}
