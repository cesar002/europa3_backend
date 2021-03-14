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
		'usado',
	];

	public function getImage()
	{
		$url = $this->pathImages == null ? $this->image : "{$this->pathImages->pathMaster->path}/{$this->pathImages->path}/{$this->image}";

		return $url;
	}

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

	public function salasJuntas(){
		return $this->belongsToMany(\App\SalaJuntas::class, 'mobiliario_sala_juntas', 'mobiliario_id', 'sala_juntas_id');
	}

	public function mobiliarioAsignadoSalaJuntas(){
		return $this->hasMany(\App\MobiliarioSalaJuntas::class, 'mobiliario_id');
	}

	public function mobiliarioAsignadoOficina(){
		return $this->hasMany(\App\MobiliarioOficina::class, 'mobiliario_id');
	}

}
