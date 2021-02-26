<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoTiempoRenta extends Model
{
	protected $table = 'cat_tiempo_renta';

	protected $hidden = [
		'created_at', 'updated_at',
	];
}
