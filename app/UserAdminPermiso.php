<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAdminPermiso extends Model
{
	protected $table = 'users_admin_permisos';

	public function userAdmin(){
		return $this->belongsTo(\App\UserAdmin::class, 'user_admin_id');
	}

	public function permiso(){
		return $this->belongsTo(\App\PermisosModulos::class, 'permiso_id');
	}
}
