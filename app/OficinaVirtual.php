<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OficinaVirtual extends Model
{
	use SoftDeletes;

	protected $table = 'oficinas_virtuales';

	protected $fillable = [
		'edificio_id', 'tipo_oficina_id', 'tipo_tiempo_id',
		'nombre', 'descripcion', 'precio', 'en_uso',
	];

	protected $hidden = [
		'created_at', 'updated_at', 'deleted_at',
	];

	protected $casts = [
		'en_uso' => 'boolean'
	];


	public function edificio(){
        return $this->belongsTo(\App\Edificio::class, 'edificio_id');
    }

	public function tipoOficina(){
        return $this->belongsTo(\App\CatTipoOficina::class, 'tipo_oficina_id');
	}

	public function tipoTiempoRenta(){
		return $this->belongsTo(\App\CatTiempoRenta::class, 'tipo_tiempo_id');
	}

	public function servicios(){
        return $this->belongsToMany(\App\CatServiciosOficina::class, 'oficina_virtual_servicios', 'oficina_virtual_id', 'servicio_id');
	}

	public function solicitud(){
		return $this->morphOne(\App\SolicitudReservacion::class, 'solicitudable');
	}

}
