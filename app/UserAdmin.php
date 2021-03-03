<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserAdmin extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

	protected $table = 'users_admin';

	protected $guard = 'api-admin';

	protected $fillable = [
		'username', 'password',
		'edificio_id',
	];

	protected $hidden = [
		'password', 'created_at', 'updated_at',
	];

	public function findForPassport($username) {
        return $this->where('username', $username)->first();
	}

	public function permisos(){
		return $this->hasMany(\App\UserAdminPermiso::class, 'user_admin_id');
	}

	public function edificio(){
		// return $this->belongsToMany(\App\Edificio::class, 'edificio', 'user_admin_id', 'edificio_id');
		return $this->belongsTo(\App\Edificio::class, 'edificio_id');
	}

	public function insumos(){
		return $this->hasMany(\App\InsumoComprado::class, 'user_admin_id');
	}

	public function infoPersonal(){
		return $this->hasOne(\App\UserAdminPersonalData::class, 'user_admin_id');
	}

	public function chatRecepcion(){
		return $this->morphMany(\App\ChatRecepcion::class, 'chatable');
	}

}
