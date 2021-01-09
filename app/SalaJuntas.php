<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaJuntas extends Model{
	protected $table = 'sala_juntas';

	protected $fillable = [
		'edificio_id',
		'tipo_oficina_id',
		'size_id',
		'nombre',
		'descripcion',
		'size_dimension',
		'capacidad_recomendada',
		'capacidad_maxima',
		'precio',
		'path_image_id',
		'tipo_tiempo_id',
	];

	protected $hidden = [
		'created_at', 'updated_at',
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

	public function size(){
		return $this->belongsTo(\App\CatSizeOficina::class, 'size_id');
	}

	public function pathImages(){
		return $this->belongsTo(\App\PathImage::class, 'path_image_id');
	}

	public function servicios(){
		return $this->belongsToMany(\App\CatServiciosOficina::class, 'sala_juntas_servicios', 'sala_juntas_id', 'servicio_id');
	}

	public function imagenes(){
		return $this->hasMany(\App\SalaJuntasImagenes::class, 'sala_juntas_id');
	}

	public function mobiliario(){
		return $this->belongsToMany(\App\Mobiliario::class, 'mobiliario_sala_juntas', 'sala_juntas_id', 'mobiliario_id');
	}

	public function mobiliarioAsignado(){
		return $this->hasMany(\App\MobiliarioSalaJuntas::class, 'sala_juntas_id');
	}

	public function tipoTiempoRenta(){
		return $this->belongsTo(\App\CatTiempoRenta::class, 'tipo_tiempo_id');
	}

	public function solicitud(){
		return $this->morphOne(\App\SolicitudReservacion::class, 'solicitudable');
	}

}
