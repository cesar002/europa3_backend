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
		'capacidad_recomendada', 'capacidad_maxima', 'en_uso', 'precio',
		'path_image_id', 'tipo_tiempo_id',
	];

	protected $hidden = [
		'created_at', 'updated_at', 'deleted_at',
	];

	public function getImagesPath()
	{
		if($this->pathImages == null){ return ''; }

		return  "{$this->pathImages->pathMaster->path}/{$this->pathImages->path}";
	}

	public function getFirstImage()
	{
		$image = $this->imagenes[0];
		return '';
		// if($this->imagenes == null || count($this->imagenes) <= 0){ return ''; }


		// return "{$image->path->pathMaster->path}/{$image->path->path}/{$image->image}";
	}

    public function edificio(){
        return $this->belongsTo(\App\Edificio::class, 'edificio_id');
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

	public function mobiliarioAsignado(){
		return $this->hasMany(\App\MobiliarioOficina::class, 'oficina_id');
	}

	public function pathImages(){
		return $this->belongsTo(\App\PathImage::class, 'path_image_id');
	}

	public function tipoTiempoRenta(){
		return $this->belongsTo(\App\CatTiempoRenta::class, 'tipo_tiempo_id');
	}

	public function solicitud(){
		return $this->morphOne(\App\SolicitudReservacion::class, 'solicitudable');
	}

	public function solicitudVisita(){
		return $this->morphOne(\App\SolicitudVisita::class, 'solicitudable');
	}

}
