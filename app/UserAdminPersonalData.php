<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAdminPersonalData extends Model
{
	protected $table = 'user_admin_datos_personales';

	protected $hidden = [
		'created_at', 'updated_at', 'path_id', 'user_admin_id'
	];

	protected $fillable = [
		'user_admin_id', 'nombre', 'ap_m', 'ap_p', 'path_id', 'avatar_image'
	];


	public function userAdmin(){
		return $this->belongsTo(\App\UserAdmin::class, 'user_admin_id');
	}

	public function pathImage(){
		return $this->belongsTo(\App\PathImage::class, 'path_id');
	}

}
