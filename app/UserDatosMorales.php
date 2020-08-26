<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDatosMorales extends Model
{
    protected $table = 'user_datos_morales';

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
