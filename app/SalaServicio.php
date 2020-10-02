<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaServicio extends Model
{
	protected $table = 'sala_juntas_servicios';

	protected $fillable = [
		'sala_juntas_id', 'servicio_id',
	];

	protected $hidden = [
		'created_at', 'updated_at',
	];

}
