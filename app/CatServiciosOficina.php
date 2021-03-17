<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatServiciosOficina extends Model
{

	use SoftDeletes;

	protected $table = 'cat_servicios';

	protected $hidden = [
		'created_at',
		'updated_at',
	];

	protected $fillable = [
		'servicio',
	];

    public function oficinas(){
        return $this->belongsToMany(\App\Oficina::class, 'oficina_servicios', 'servicio_id', 'oficina_id');
	}

	public function oficinasVirtuales(){
		return $this->belongsToMany(\App\OficinaVirtual::class,'oficina_virtual_servicios', 'oficina_virtual_id', 'servicio_id');
	}

	public function salasJuntas(){
		return $this->belongsToMany(\App\SalaJuntas::class, 'sala_juntas_servicios', 'servicio_id', 'sala_juntas_id');
	}
}
