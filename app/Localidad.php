<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
	protected $table = 'localidades';

	public function edificios(){
		return $this->hasMany(\App\Edificio::class, 'edificio_id');
	}

	public function municipio(){
		return $this->belongsTo(\App\Municipio::class, 'municipio_id');
	}

}
