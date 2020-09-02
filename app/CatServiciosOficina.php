<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatServiciosOficina extends Model
{
	protected $table = 'cat_servicios_oficina';

	protected $hidden = [
		'created_at',
		'updated_at',
	];

    public function oficinas(){
        return $this->belongsToMany(\App\Oficina::class, 'oficina_servicios', 'servicio_id', 'oficina_id');
    }
}
