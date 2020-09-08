<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaJuntas extends Model{
	protected $table = 'sala_juntas';

	protected $hidden = [
		'created_at', 'updated_at',
	];

	protected $casts = [
		'en_uso' => 'boolean'
	];


	public function edificio(){
		return $this->belongsTo(\App\Edificio::class, 'edificio_id');
	}

	public function tipoOficina(){
		return $this->belongsTo(\App\CatTipoOficina::class, 'tipo_id');
	}

	public function size(){
		return $this->belongsTo(\App\CatSizeOficina::class, 'size_id');
	}

}
