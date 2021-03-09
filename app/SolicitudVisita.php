<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudVisita extends Model
{
    protected $table = 'solicitudes_visitas';

	protected $fillable = [
		'nombre', 'email', 'telefono', 'comentario', 'activo',
	];

	protected $hidden = [ 'updated_at' ];

}
