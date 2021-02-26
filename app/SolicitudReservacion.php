<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitudReservacion extends Model
{
	use SoftDeletes;

	protected $table = 'solicitud_reservacion';

	protected $casts = [
		'terminos_condiciones' => 'boolean',
	];

	protected $fillable = [
		'folio', 'user_id', 'solicitud_id', 'estado_id',
		'metodo_pago_id', 'tipo_oficina', 'fecha_reservacion',
		'meses_renta', 'numero_integrantes', 'hora_inicio', 'hora_fin',
	];

	protected $hidden = [
		'solicitudable_id', 'created_at', 'updated_at', 'deleted_at'
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

	public function estado(){
		return $this->belongsTo(\App\CatEstadoSolicitud::class, 'estado_id');
	}

	public function notificacionesSolicitud(){
		return $this->hasMany(\App\NotificationSolicitudMessage::class, 'solicitud_id');
	}

	public function solicitudable(){
		return $this->morphTo();
	}

	public function metodoPago(){
		return $this->belongsTo(\App\MetodoPago::class, 'metodo_pago_id');
	}

	public function tipoOficina(){
		return $this->belongsTo(\App\CatTipoOficina::class, 'tipo_oficina');
	}

	public function chats(){
		return $this->hasMany(\App\ChatRecepcion::class, 'solicitud_id');
	}

	public function adicionalesComprados(){
		return $this->hasMany(\App\AdicionalCompraSolicitud::class, 'solicitud_id');
	}

}
