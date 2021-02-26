<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDatosMorales extends Model
{
	protected $table = 'user_datos_morales';

	protected $fillable = [
		'user_id', 'nombre_empresa', 'nombre', 'ape_p', 'ape_m', 'escritura_publica',
		'numero_notario', 'fecha_constitucion', 'giro_comercial', 'telefono', 'email',
	];

	protected $hidden = [
		'created_at', 'updated_at', 'user_id',
	];

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
