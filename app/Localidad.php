<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
	protected $table = 'localidades';

	public function municipio(){
		return $this->belongsTo(\App\Municipio::class, 'municipio_id');
	}

}
