<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroPago extends Model
{
    protected $table = 'registro_pagos';

    public function fechaPago(){
        return $this->belongsTo(\App\FechaPago::class, 'fecha_id');
	}

	protected $casts = [
		'verificado' => 'boolean',
	];

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
