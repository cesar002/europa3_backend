<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDatoPersonal extends Model
{
	protected $table = 'user_datos_personales';

	protected $fillable = [
		'user_id', 'nacionalidad_id', 'nombre', 'ape_p', 'ape_m', 'RFC', 'CURP',
		'fecha_nacimiento', 'celular', 'domicilio', 'telefono',
	];

	protected $casts = [
	];

    public function user(){
        return $this->belongsTo(\App\User::class);
    }

    public function nacionalidad(){
        return $this->belongsTo(\App\Nacionalidad::class, 'nacionalidad_id');
    }

}
