<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoIdentificacion extends Model
{
	protected $table = 'cat_tipos_identificacion';

	protected $hidden = [
		'created_at', 'updated_at',
	];

	public function datosPersonales(){
		return $this->hasMany(\App\UserDatoPersonal::class, 'tipo_identificacion_id');
	}
}
