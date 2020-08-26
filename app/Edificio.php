<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Edificio extends Model
{
    protected $table = 'edificios';

    public function localidad(){
        return $this->belongsTo(\App\Localidad::class, 'localidad_id');
    }

    public function oficinas(){
        return $this->hasMany(\App\Oficina::class, 'edificio_id');
	}

	public function mobiliario(){
		return $this->hasMany(\App\Mobiliario::class, 'edificio_id');
	}

	public function chatsSoporte(){
		return $this->hasMany(\App\ChatSoporte::class, 'edificio_id');
	}

	public function chatsRecepcion(){
		return $this->hasMany(\App\ChatRecepcion::class, 'edificio_id');
	}

	public function usersAdmin(){
		return $this->belongsToMany(\App\UserAdmin::class, 'users_admin_edificios', 'edificio_id', 'user_admin_id');
	}

	public function idiomas(){
		return $this->belongsToMany(\App\CatIdiomasAtencion::class, 'edificio_id', 'idioma_id');
	}

}
