<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroPago extends Model
{
	protected $table = 'registro_pagos';

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
