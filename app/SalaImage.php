<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaImage extends Model
{
	protected $table = 'sala_juntas_imagenes';

	protected $fillable = [
		'sala_juntas_id', 'image',
	];

	protected $hidden = [
		'created_at', 'updated_at',
	];

	public function salaJuntas(){
		return $this->belongsTo(\App\SalaJuntas::class, 'sala_juntas_id');
	}

	public function path(){
		return $this->belongsTo(\App\PathImage::class, 'path_id');
	}

}
