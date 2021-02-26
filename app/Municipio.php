<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
	protected $table = 'municipios';


	public function estado(){
		return $this->belongsTo(\App\Estado::class, 'estado_id');
	}

	public function localidades(){
		return $this->hasMany(\App\Localidad::class, 'municipio_id');
	}

	public function userDatosFiscales(){
		return $this->hasMany(\App\UserDatosFiscales::class, 'municipio_id');
	}

	public function edificios(){
		return $this->hasMany(\App\Edificio::class, 'municipio_id');
	}
}
