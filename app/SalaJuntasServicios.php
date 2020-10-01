<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaJuntasServicios extends Model
{
	protected $table = 'sala_juntas_servicios';

	protected $hidden = [
		'created_at', 'updated_at',
	];

	protected $fillable = [
		'sala_juntas_id', 'servicio_id',
	];
}
