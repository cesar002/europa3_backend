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

	public function getFullName()
	{
		$info = $this->infoPersonal()->first();

		return "{$info->nombre} {$info->ap_p} {$info->ap_m}";
	}

	public function getAvatar()
	{
		$info = $this->infoPersonal()->with('pathImage', 'pathImage.pathMaster')->first();
		$path = "{$info->pathImage->pathMaster->path}/{$info->pathImage->path}";

		if ($info->avatar_image == null){
			return null;
		}

		return \Illuminate\Support\Facades\Storage::url("{$path}/{$info->avatar_image}");
	}

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
