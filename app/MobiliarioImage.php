<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobiliarioImage extends Model
{
	protected $table = 'mobiliario_images';

	public function mobiliario(){
		return $this->belongsTo(\App\Mobiliario::class, 'mobiliario_id');
	}

	public function path(){
		return $this->belongsTo(\App\PathImage::class, 'path_images_id');
	}

}
