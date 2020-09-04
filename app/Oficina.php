<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oficina extends Model
{
	protected $table = 'oficinas';

	protected $casts = [
		'en_uso' => 'boolean'
	];

	protected $fillable = [
		'edificio_id', 'tipo_oficina_id', 'size_id', 'nombre', 'descripcion', 'size_dimension',
		'capacidad_recomendada', 'capacidad_maxima', 'en_uso', 'precio'
	];


    public function edificio(){
        return $this->belongsTo(\App\Edificio::class, 'edificio_id');
    }

    public function solicitudesReservacion(){
        return $this->hasMany(\App\SolicitudReservacion::class, 'oficina_id');
	}

	public function imagenes(){
		return $this->hasMany(\App\OficinaImage::class, 'oficina_id');
	}

    public function tipoOficina(){
        return $this->belongsTo(\App\CatTipoOficina::class, 'tipo_oficina_id');
    }

    public function size(){
        return $this->belongsTo(\App\CatSizeOficina::class, 'size_id');
    }

    public function servicios(){
        return $this->belongsToMany(\App\CatServiciosOficina::class, 'oficina_servicios', 'oficina_id', 'servicio_id');
    }

    public function insumos(){
        return $this->hasMany(\App\InsumoComprado::class, 'oficina_id');
	}

	public function mobiliario(){
		return $this->belongsToMany(\App\Mobiliario::class, 'mobiliario_oficina', 'oficina_id', 'mobiliario_id');
	}


}
