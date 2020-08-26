<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsumoUsado extends Model
{
    protected $table = 'insumos_usados';

    public function insumoComprado(){
        return $this->belongsTo(\App\InsumoComprado::class, 'insumo_comprado_id');
    }

    public function userAdmin(){
        return $this->belongsTo(\App\UserAdmin::class, 'user_admin_id');
    }
}
