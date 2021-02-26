<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgendaUser extends Model
{
    protected $table = 'agendas_users';

	protected $fillable = [
		'user_id', 'fecha_actividad', 'hora_actividad',
		'titulo', 'descripcion',
	];

	public function user()
	{
		return $this->belongsTo(\App\User::class);
	}
}
