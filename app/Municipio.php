<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
	protected $table = 'municipios';


	public function localidades(){
		return $this->hasMany(\App\Localidad::class, 'municipio_id');
	}

	public function userDatosFiscales(){
		return $this->hasMany(\App\UserDatosFiscales::class, 'municipio_id');
	}
}
