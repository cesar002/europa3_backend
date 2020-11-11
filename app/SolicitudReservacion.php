<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitudReservacion extends Model
{
	use SoftDeletes;

	protected $table = 'solicitud_reservacion';

	protected $casts = [
		'iniciado' => 'boolean',
		'subida_documentos' => 'boolean',
		'en_revision' => 'boolean',
		'autorizado' => 'boolean',
		'finalizado' => 'boolean',
		'revalidado' => 'boolean',
		'terminos_condiciones' => 'boolean',
	];

	protected $fillable = [
		'folio', 'user_id', 'solicitud_id'
	];

	protected $hidden = [
		'created_at', 'updated_at', 'deleted_at',
	];

    public function user(){
        return $this->belongsTo(\App\User::class);
    }

    public function documentos(){
        return $this->hasMany(\App\DocumentoSolicitud::class, 'solicitud_id');
    }

    public function fechasPago(){
        return $this->hasMany(\App\FechaPago::class, 'solicitud_id');
	}

	public function solicitudOficina(){
		return $this->hasOne(\App\SolicitudOficina::class, 'solicitud_id');
	}

	public function solicitudSalaJunta(){
		return $this->hasOne(\App\SolicitudSalaJunta::class, 'solicitud_id');
	}

	public function notificacionesSolicitud(){
		return $this->hasMany(\App\NotificacionSolicitudEdificio::class, 'solicitud_id');
	}
}
