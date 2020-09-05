<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudReservacion extends Model
{
	protected $table = 'solicitud_reservacion';

	protected $casts = [
		'finalizado' => 'boolean',
		'revalidado' => 'boolean',
		'terminos_condiciones' => 'boolean',
	];

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

	public function autorizado(){
		return $this->hasOne(\App\AutorizacionEstado::class, 'solicitud_id');
	}

	public function metodoPago(){
		return $this->belongsTo(\App\MetodoPago::class, 'metodo_pago_id');
	}
}
