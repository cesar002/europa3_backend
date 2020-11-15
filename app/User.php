<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'created_at', 'updated_at',
    ];

    protected $casts = [
		'email_verified' => 'boolean'
	];

	public function getNotificationToken(){
		return is_null($this->push_notification_token) ? '' : $this->push_notification_token;
	}

    public function infoPersonal(){
        return $this->hasOne(\App\UserDatoPersonal::class);
    }

    public function datosMorales(){
        return $this->hasOne(\App\UserDatosMorales::class);
    }

    public function datosFiscales(){
        return $this->hasOne(\App\UserDatosFiscales::class);
    }

    public function solicitudesReservacion(){
        return $this->hasMany(\App\SolicitudReservacion::class);
    }

    public function pagos(){
        return $this->hasMany(\App\RegistroPago::class);
    }

    public function insumosComprados(){
        return $this->hasMany(\App\InsumoComprado::class);
	}

	public function chatRecepcion(){
		return $this->hasMany(\App\ChatRecepcion::class);
	}

	public function chatSoporte(){
		// return $this->morphToMany(\App\ChatSoporte::class, 'usertable');
	}

	public function notificacionesSolicitud(){
		return $this->hasMany(\App\NotificacionSolicitudEdificio::class, 'user_id');
	}

}
