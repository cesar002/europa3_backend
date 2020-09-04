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
		'marca',
		'modelo',
		'color',
		'descripcion_bien',
		'observaciones',
		'cantidad',
	];

	public function tipo(){
		return $this->belongsTo(\App\TipoMobiliario::class, 'tipo_id');
	}

	public function edificio(){
		return $this->belongsTo(\App\Edificio::class, 'edificio_id');
	}

	public function imagenes(){
		return $this->hasMany(\App\MobiliarioImage::class, 'mobiliario_id');
	}

	public function oficinas(){
		return $this->belongsToMany(\App\Oficina::class, 'mobiliario_oficina', 'mobiliario_id', 'oficina_id');
	}

}
