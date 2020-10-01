<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaJuntasImagenes extends Model
{
	protected $table = 'sala_juntas_imagenes';

	protected $hidden = [
		'created_at', 'updated_at',
	];

	protected $fillable = [
		'sala_juntas_id', 'image',
	];


	public function oficina(){
		return $this->belongsTo(\App\SalaJuntas::class, 'sala_juntas_id');
	}

}
