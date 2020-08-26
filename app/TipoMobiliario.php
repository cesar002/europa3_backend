<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMobiliario extends Model
{
	protected $table = 'tipos_mobiliario';


	public function mobiliario(){
		return $this->belongsTo(\App\Mobiliario::class, 'mobiliario_id');
	}

}
