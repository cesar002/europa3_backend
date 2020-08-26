<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nacionalidad extends Model
{
    protected $table = 'cat_nacionalidades';

    public function datosPersonalesUsuario(){
        return $this->hasMany(\App\UserDatoPersonal::class, 'nacionalidad_id');
    }
}
