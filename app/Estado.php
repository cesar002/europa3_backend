<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
	protected $table = 'estados';


	public function municipios(){
		return $this->hasMany(\App\Municipio::class, 'estado_id');
	}

	public function userDatosFiscales(){
		return $this->hasMany(\App\UserDatosFiscales::class, 'estado_id');
	}

}
