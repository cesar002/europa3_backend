<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatTiempoRenta extends Model
{
	protected $table = 'cat_tiempo_renta';

	protected $hidden = [
		'created_at', 'updated_at'
	];

	protected $fillable = [
		'tiempo',
	];

	public function salasJuntas(){
		return $this->hasMany(\App\SalaJuntas::class, 'tipo_tiempo_id');
	}

	public function oficinas(){
		return $this->hasMany(\App\Oficina::class, 'tipo_tiempo_id');
	}

}
