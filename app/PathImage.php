<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PathImage extends Model
{
	protected $table = 'path_images';

	protected $fillable = [
		'path_master_id',
		'nombre',
		'path',
	];

	public function pathMaster(){
		return $this->belongsTo(\App\PathMaster::class, 'path_master_id');
	}


	public function oficinas(){
		return $this->hasMany(\App\Oficina::class, 'path_image_id');
	}

	public function imagenesMobiliario(){
		return $this->hasMany(\App\MobiliarioImage::class, 'path_images_id');
	}

	public function imagenesAvatarUserAdmin(){
		return $this->hasMany(\App\UserAdminPersonalData::class, 'path_id');
	}
}
