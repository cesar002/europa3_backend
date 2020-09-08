<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermisosModulos extends Model{
	protected $table = 'cat_permisos_modulos';


	public function permisos(){
		return $this->hasMany(\App\UserAdminPermiso::class, 'permiso_id');
	}
}
