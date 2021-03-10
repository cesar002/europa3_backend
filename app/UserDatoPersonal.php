<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDatoPersonal extends Model
{
	protected $table = 'user_datos_personales';

	protected $fillable = [
		'user_id', 'nacionalidad_id', 'nombre', 'ape_p', 'ape_m', 'RFC', 'CURP',
		'fecha_nacimiento', 'celular', 'domicilio', 'telefono', 'tipo_identificacion_id',
		'tipo_identificacion_otro', 'numero_identificacion',
	];

	protected $hidden = [
		'created_at', 'updated_at',
	];

	// protected $casts = [
	// 	// 'fecha_nacimiento' => 'date:Y-m-d',
	// ];

	public function getFullName()
	{
		return "{$this->nombre} {$this->ape_p} {$this->ape_m}";
	}

    public function user(){
        return $this->belongsTo(\App\User::class);
    }

    public function nacionalidad(){
        return $this->belongsTo(\App\Nacionalidad::class, 'nacionalidad_id');
	}

	public function tipoIdentificacion(){
		return $this->belongsTo(\App\TipoIdentificacion::class, 'tipo_identificacion_id');
	}

}
