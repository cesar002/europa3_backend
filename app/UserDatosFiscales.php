<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDatosFiscales extends Model
{
    protected $table = 'user_datos_fiscales';

    public function user(){
        return $this->belongsTo(\App\User::class);
    }

    public function estado(){
        return $this->belongsTo(\App\Estado::class, 'estado_id');
    }

    public function municipio(){
        return $this->belongsTo(\App\Municipio::class, 'municipio_id');
    }
}
