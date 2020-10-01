<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobiliarioOficina extends Model
{
	protected $table = 'mobiliario_oficina';

	protected $hidden = [
		'created_at', 'updated_at',
	];

	protected $fillable = [
		'oficina_id', 'mobiliario_id'
	];

}
