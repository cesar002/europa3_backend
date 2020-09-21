<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mobiliario extends Model
{
	protected $table = 'mobiliarios';

	protected $casts = [
		'activo' => 'boolean',
	];

	protected $fillable = [
		'tipo_id',
		'edificio_id',
		'nombre',
		'marca',
		'modelo',
		'color',
		'descripcion_bien',
		'observaciones',
		'cantidad',
		'path_id',
		'image',
	];

	public function getDescripcion(){
		return $this->observaciones ?? '';
	}

	public function tipo(){
		return $this->belongsTo(\App\TipoMobiliario::class, 'tipo_id');
	}

	public function edificio(){
		return $this->belongsTo(\App\Edificio::class, 'edificio_id');
	}

	public function pathImages(){
		return $this->belongsTo(\App\PathImage::class, 'path_id');
	}

	public function oficinas(){
		return $this->belongsToMany(\App\Oficina::class, 'mobiliario_oficina', 'mobiliario_id', 'oficina_id');
	}

}
