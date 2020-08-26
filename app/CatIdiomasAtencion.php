<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatIdiomasAtencion extends Model
{
	protected $table = 'cat_idiomas_atencion';

	public function edificios(){
		return $this->belongsToMany(\App\Edificio::class, 'edificio_idiomas_atencion', 'idioma_id', 'edificio_id');
	}
}
