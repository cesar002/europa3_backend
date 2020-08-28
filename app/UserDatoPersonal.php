<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDatoPersonal extends Model
{
    protected $table = 'user_datos_personales';

	protected $casts = [
	];

    public function user(){
        return $this->belongsTo(\App\User::class);
    }

    public function nacionalidad(){
        return $this->belongsTo(\App\Nacionalidad::class, 'nacionalidad_id');
    }

}
