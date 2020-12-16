<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroPago extends Model
{
	protected $table = 'registro_pagos';

	protected $fillable = [
		'user_id', 'fecha_id', 'referencia', 'fecha_pago', 'verificado'
	];

	protected $hidden = [
		'created_at', 'updated_at',
	];

	protected $casts = [
		'verificado' => 'boolean',
	];

    public function fechaPago(){
        return $this->belongsTo(\App\FechaPago::class, 'fecha_id');
	}

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
