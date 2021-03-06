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

	public function salasJuntas(){
		return $this->hasMany(\App\SalaJuntas::class, 'path_image_id');
	}

	public function mobiliarios(){
		return $this->hasMany(\App\Mobiliario::class, 'path_id');
	}

	public function imagenesAvatarUserAdmin(){
		return $this->hasMany(\App\UserAdminPersonalData::class, 'path_id');
	}
}
