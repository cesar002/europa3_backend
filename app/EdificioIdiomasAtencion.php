<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EdificioIdiomasAtencion extends Model
{
	protected $table = 'edificio_idiomas_atencion';

	protected $fillable = [
		'edificio_id',
		'idioma_id',
	];

}
