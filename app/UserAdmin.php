<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserAdmin extends Authenticatable
{
    use Notifiable;

	protected $table = 'users_admin';


	public function permisos(){
		return $this->hasMany(\App\UserAdminPermiso::class, 'user_admin_id');
	}

	public function edificios(){
		return $this->belongsToMany(\App\Edificio::class, 'users_admin_edificios', 'user_admin_id', 'edificio_id');
	}

	public function insumos(){
		return $this->hasMany(\App\InsumoComprado::class, 'user_admin_id');
	}

}
