<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adicional extends Model
{
	protected $table = 'adicionales';

	protected $casts = [
		'disponible' => 'boolean',
	];

	protected $fillable = [
		'edificio_id', 'unidad_id', 'nombre', 'descripcion',
		'precio', 'disponible', 'unidad_base', 'cantidad_maxima',
	];

	protected $hidden = [
		'created_at', 'updated_at', 'deleted_at',
	];

	public function unidad(){
		return $this->belongsTo(\App\CatUnidadAdicional::class, 'unidad_id');
	}

	public function edificio(){
		return $this->belongsTo(\App\Edificio::class, 'edificio_id');
	}

	public function comprados(){
		return $this->hasMany(\App\AdicionalComprado::class, 'adicional_id');
	}

}
