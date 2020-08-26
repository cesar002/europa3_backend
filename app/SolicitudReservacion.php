<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudReservacion extends Model
{
    protected $table = 'solicitud_reservacion';

    public function user(){
        return $this->belongsTo(\App\User::class);
    }

    public function oficina(){
        return $this->belongsTo(\App\Oficina::class, 'oficina_id');
    }

    public function documentos(){
        return $this->hasMany(\App\DocumentoSolicitud::class, 'solicitud_id');
    }

    public function fechasPago(){
        return $this->hasMany(\App\FechaPago::class, 'solicitud_id');
    }
}
