<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDatosFiscales extends Model
{
	protected $table = 'user_datos_fiscales';

	protected $fillable = [
		'user_id', 'estado_id', 'municipio_id', 'email', 'razon_social',
		'RFC', 'telefono', 'calle', 'numero_exterior', 'numero_interior',
		'codigo_postal', 'colonia'
	];

	protected $hidden = [
		'created_at', 'updated_at',
	];

    public function user(){
        return $this->belongsTo(\App\User::class);
    }

    public function estado(){
        return $this->belongsTo(\App\Estado::class, 'estado_id');
    }

    public function municipio(){
        return $this->belongsTo(\App\Municipio::class, 'municipio_id');
    }
}
