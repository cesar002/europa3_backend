<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatUnidadAdicional extends Model
{
	protected $table = 'cat_unidad_adicional';

	protected $hidden = [
		'created_at', 'updated_at'
	];

	public function adicionales(){
		return $this->hasMany(\App\Adicional::class, 'unidad_id');
	}

}
