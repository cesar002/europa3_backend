<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMobiliario extends Model
{
	protected $table = 'tipos_mobiliario';

	protected $hidden = [
		'created_at', 'updated_at'
	];


	public function mobiliario(){
		return $this->belongsTo(\App\Mobiliario::class, 'mobiliario_id');
	}

}
