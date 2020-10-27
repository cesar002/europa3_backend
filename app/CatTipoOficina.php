<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatTipoOficina extends Model
{
	protected $table = 'cat_tipos_oficina';

	protected $hidden = [
		'created_at', 'updated_at'
	];

    public function oficinas(){
        return $this->hasMany(\App\Oficina::class, 'tipo_oficina_id');
	}

	public function salasJuntas(){
		return $this->hasMany(\App\SalaJuntas::class, 'tipo_oficina_id');
	}
}
