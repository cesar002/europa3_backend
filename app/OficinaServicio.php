<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OficinaServicio extends Model
{
	protected $table = 'oficina_servicios';

	protected $fillable = [
		'oficina_id',
		'servicio_id',
	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];
}
