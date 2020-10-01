<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobiliarioSalaJuntas extends Model
{
	protected $table = 'mobiliario_sala_juntas';

	protected $hidden = [
		'created_at', 'updated_at',
	];

	protected $fillable = [
		'sala_juntas_id', 'mobiliario_id',
	];
}
