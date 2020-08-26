<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PathImage extends Model
{
	protected $table = 'path_images';

	public function pathMaster(){
		return $this->belongsTo(\App\PathMaster::class, 'path_master_id');
	}


	public function imagenesOficina(){
		return $this->hasMany(\App\OficinaImage::class, 'path_id');
	}

	public function imagenesMobiliario(){
		return $this->hasMany(\App\MobiliarioImage::class, 'path_images_id');
	}
}
