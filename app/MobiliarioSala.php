<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobiliarioSala extends Model{

	protected $table = 'mobiliario_sala_juntas';

	protected $fillable = [
		'sala_juntas_id', 'mobiliario_id',
	];

	protected $hidden = [
		'created_at', 'updated_at',
	];



}
