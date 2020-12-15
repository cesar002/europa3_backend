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
		'unidad_id', 'nombre', 'descripcion',
		'precio', 'disponible',
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
		return $this->belongsTo(\App\AdicionalComprado::class, 'adicional_id');
	}

}
