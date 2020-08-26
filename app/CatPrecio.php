<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatPrecio extends Model
{
	protected $table = 'cat_precios';

	public function size(){
		return $this->belongsTo(\App\CatSizeOficina::class, 'size_id');
	}
}
