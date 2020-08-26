<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OficinaImage extends Model
{
	protected $table = 'oficina_imagenes';

	public function oficina(){
		return $this->belongsTo(\App\Oficina::class, 'oficina_id');
	}

	public function path(){
		return $this->belongsTo(\App\PathImage::class, 'path_id');
	}

}
