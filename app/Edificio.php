<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Edificio extends Model
{
	protected $table = 'edificios';

	protected $fillable = [
		'municipio_id', 'nombre', 'direccion', 'telefono_1', 'telefono_2', 'telefono_recepcion',
		'lat', 'lon', 'hora_apertura', 'hora_cierre',
	];

    public function municipio(){
        return $this->belongsTo(\App\Municipio::class, 'municipio_id');
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
